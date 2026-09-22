<?php

class PG
{
    public static function all(): array
    {
        $stmt = Database::pdo()->query('SELECT * FROM pgs ORDER BY created_at DESC');
        return $stmt->fetchAll();
    }

    public static function byOwner(int $ownerId): array
    {
        $stmt = Database::pdo()->prepare('SELECT * FROM pgs WHERE owner_id = :owner_id ORDER BY created_at DESC');
        $stmt->execute(['owner_id' => $ownerId]);
        return $stmt->fetchAll();
    }

    public static function publicListings(): array
    {
        $stmt = Database::pdo()->query('SELECT * FROM pgs WHERE is_approved = 1 AND is_active = 1 ORDER BY created_at DESC LIMIT 12');
        return $stmt->fetchAll();
    }

    public static function search(string $query = '', ?string $gender = null, ?string $roomType = null, ?int $maxPrice = null): array
    {
        $sql = 'SELECT * FROM pgs WHERE is_approved = 1 AND is_active = 1';
        $params = [];

        if ($query !== '') {
            $sql .= ' AND (name LIKE :query OR city LIKE :query OR area LIKE :query OR address LIKE :query)';
            $params['query'] = '%' . $query . '%';
        }

        if ($gender !== null && $gender !== '') {
            $sql .= ' AND gender = :gender';
            $params['gender'] = $gender;
        }

        if ($roomType !== null && $roomType !== '') {
            $sql .= ' AND room_type = :room_type';
            $params['room_type'] = $roomType;
        }

        if ($maxPrice !== null && $maxPrice > 0) {
            $sql .= ' AND price_from <= :max_price';
            $params['max_price'] = $maxPrice;
        }

        $sql .= ' ORDER BY created_at DESC LIMIT 12';
        $stmt = Database::pdo()->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public static function findById(int $id): ?array
    {
        $stmt = Database::pdo()->prepare('SELECT * FROM pgs WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public static function roomsForOwner(int $ownerId): array
    {
        $stmt = Database::pdo()->prepare('SELECT rooms.*, pgs.name AS pg_name FROM rooms JOIN pgs ON pgs.id = rooms.pg_id WHERE pgs.owner_id = :owner_id ORDER BY pgs.name, rooms.room_number');
        $stmt->execute(['owner_id' => $ownerId]);
        return $stmt->fetchAll();
    }

    public static function create(array $data, int $ownerId, bool $isApproved = false): int
    {
        $stmt = Database::pdo()->prepare('INSERT INTO pgs (owner_id, name, city, area, address, price_from, gender, room_type, is_approved, is_active, rating) VALUES (:owner_id, :name, :city, :area, :address, :price_from, :gender, :room_type, :is_approved, 1, 0)');
        $stmt->execute([
            'owner_id' => $ownerId,
            'name' => $data['name'],
            'city' => $data['city'],
            'area' => $data['area'],
            'address' => $data['address'],
            'price_from' => $data['price_from'],
            'gender' => $data['gender'],
            'room_type' => $data['room_type'],
            'is_approved' => $isApproved ? 1 : 0,
        ]);

        return (int) Database::pdo()->lastInsertId();
    }

    public static function updateOwned(int $id, int $ownerId, array $data): bool
    {
        $stmt = Database::pdo()->prepare('UPDATE pgs SET name = :name, city = :city, area = :area, address = :address, price_from = :price_from, gender = :gender, room_type = :room_type WHERE id = :id AND owner_id = :owner_id');
        return $stmt->execute([
            'id' => $id, 'owner_id' => $ownerId, 'name' => $data['name'], 'city' => $data['city'],
            'area' => $data['area'], 'address' => $data['address'], 'price_from' => $data['price_from'],
            'gender' => $data['gender'], 'room_type' => $data['room_type'],
        ]);
    }

    public static function createRoom(int $pgId, int $ownerId, array $data): int
    {
        $ownership = Database::pdo()->prepare('SELECT id FROM pgs WHERE id = :id AND owner_id = :owner_id');
        $ownership->execute(['id' => $pgId, 'owner_id' => $ownerId]);
        if (!$ownership->fetch()) {
            return 0;
        }

        $pdo = Database::pdo();
        $pdo->beginTransaction();
        try {
            $room = $pdo->prepare('INSERT INTO rooms (pg_id, room_number, room_type, rent, beds_total, status) VALUES (:pg_id, :room_number, :room_type, :rent, :beds_total, "active")');
            $room->execute(['pg_id' => $pgId, 'room_number' => $data['room_number'], 'room_type' => $data['room_type'], 'rent' => $data['rent'], 'beds_total' => $data['beds_total']]);
            $roomId = (int) $pdo->lastInsertId();
            $bed = $pdo->prepare('INSERT INTO beds (room_id, bed_number, status) VALUES (:room_id, :bed_number, "available")');
            for ($index = 1; $index <= (int) $data['beds_total']; $index++) {
                $bed->execute(['room_id' => $roomId, 'bed_number' => chr(64 + $index)]);
            }
            $pdo->commit();
            return $roomId;
        } catch (Throwable $exception) {
            $pdo->rollBack();
            throw $exception;
        }
    }

    public static function bedsForRoom(int $roomId): array
    {
        $stmt = Database::pdo()->prepare('SELECT * FROM beds WHERE room_id = :room_id ORDER BY bed_number');
        $stmt->execute(['room_id' => $roomId]);
        return $stmt->fetchAll();
    }
}
