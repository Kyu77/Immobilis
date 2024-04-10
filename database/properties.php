<?php

class properties
{
     public function __construct(private PDO $pdo){}


    public function findAll() {
         $query = "SELECT * FROM immobilis.properties";
         $stmt = $this->pdo->query($query);
         return $stmt->fetchAll();
    }

    public function store(string $name) {
        $query = "INSERT INTO immobilis.property_types(name) VALUES (?)";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([$name]);
   }

    public function updateById(int $id, string $name, string $title, int $price, int $rooms, int  $floor, int $bedrooms, int $surface, string $description, int $bathrooms,  string $images ,string $typeId, int $number, string $street, string $city, int  $zipcode){
         $query = <<<EOF
         SELECT JSON_OBJECT(
             'id', p.id,
             'title', p.title,
             'description', p.description,
             'images', p.images,
             'surface', p.surface,
             'price', p.price,
             'rooms', p.rooms,
             'floor', p.floor,
             'bedrooms', p.bedrooms,
             'bathrooms', p.bathrooms,
             'address', (
                 SELECT JSON_OBJECT(
                     'street', ad.street,
                     'number', ad.number,
                     'city', ad.city,
                     'zipcode', ad.zipcode
                  )
                 FROM immobilis.addresses ad
                 WHERE p.address_id = ad.id
             ),
 
             ) as properties
              FROM immobilis.properties p
             JOIN immobilis.property_types pt on p.property_type_id = pt.id
             JOIN addresses a on a.id = p.address_id
             WHERE p.id = ?
         EOF;
         $stmt = $this->pdo->prepare($query);
         return $stmt->execute([$title, $name, $id, $price, $rooms, $floor, $bedrooms, $surface, $description, $bathrooms, $images, $typeId, $number, $street, $city,$zipcode]);
    }

    public  function  findById(int $id) {
        $query = "SELECT * FROM immobilis.properties WHERE id = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch();
   }

    public function deleteById(int $id) {
         $query = "DELETE FROM immobilis.properties WHERE id = ?";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([$id]);
    }
}