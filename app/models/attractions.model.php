<?php
require_once 'db.model.php';

class AttractionModel extends Model {
	
	function getAttractions($orderBy, $page, $limit, $filterField, $filterValue) {
		
		$sql = "SELECT attractions.*, countries.name AS country FROM attractions INNER JOIN countries ON attractions.country_id = countries.id";
		
		/*if($filterField) {
            switch($filterField) {
                case 'name':
                    $sql .= ' WHERE name = ?';
                    break;
                case 'country':
                    $sql .= ' WHERE country = ?';
					break;
				case 'price':
                    $sql .= ' WHERE price = ?';
					break;
				case 'open_time':
                    $sql .= ' WHERE open_time = ?';
                    break;
            }
        }*/
		
		
		if($orderBy) {
            switch($orderBy) {
                case 'name':
                    $sql .= ' ORDER BY name';
                    break;
                case 'country':
                    $sql .= ' ORDER BY country';
					break;
				case 'price':
                    $sql .= ' ORDER BY price';
					break;
				case 'open_time':
                    $sql .= ' ORDER BY open_time';
                    break;
            }
        }
		
		if($page && $limit){
			$sql .= ' LIMIT ' . (int)$limit . ' OFFSET ' . (int)$limit*((int)$page-1);
		}
        $query = $this->db->prepare($sql);
        $query->execute([$filterValue]);  
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    
    public function getAttractionById($id) {
        $query = $this->db->prepare("SELECT attractions.*, countries.name AS country, countries.id AS idCountry, countries.currency AS currency FROM attractions INNER JOIN countries ON attractions.country_id = countries.id WHERE attractions.id = ?");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
    
    function getAttractionByCountry($country) {
        $query = $this->db->prepare("SELECT attractions.*, countries.name AS pais FROM attractions INNER JOIN countries ON attractions.country_id = countries.id WHERE countries.name = ?");
        $query->execute([$country]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    function addAttraction($name, $location, $price, $description, $open_time, $close_time, $website, $country_id, $path_img) {
		if ($path_img)
            $pathImg = $path_img;//$this->uploadImage($path_img);
		else
			$pathImg = "images/imagen-no-disponible.png";
		$query = $this->db->prepare("INSERT INTO attractions (name, location, price, path_img, description, open_time, close_time, website, country_id) VALUES(?,?,?,?,?,?,?,?,?)");
        $query->execute([$name, $location, $price, $pathImg, $description, $open_time, $close_time, $website, $country_id]);
        return $this->db->lastInsertId();
    }

    function deleteAttraction($id) {
        $query = $this->db->prepare("DELETE FROM attractions WHERE id = ?");
        $query->execute([$id]);
		return $query->rowCount();
    }

    function updateAttraction($name, $location, $price, $description, $open_time, $close_time, $website, $country_id, $id, $path_img) {
		if ($path_img){
            $pathImg = $path_img;//$this->uploadImage($path_img);
			$query = $this->db->prepare("UPDATE attractions SET name = ?, location = ?, price = ? , path_img = ?, description = ?, open_time = ?, close_time = ?, website = ?, country_id = ? WHERE id = ?");
			$query->execute([$name, $location, $price, $pathImg, $description, $open_time, $close_time, $website, $country_id, $id]);
		}else{
			$query = $this->db->prepare("UPDATE attractions SET name = ?, location = ?, price = ? , description = ?, open_time = ?, close_time = ?, website = ?, country_id = ? WHERE id = ?");
			$query->execute([$name, $location, $price, $description, $open_time, $close_time, $website, $country_id, $id]);
		}
		return $query->rowCount();
    }
	
	/*private function uploadImage ($image){
		$newFilePath = "images/" . uniqid() . "." . strtolower(pathinfo($image['name'], PATHINFO_EXTENSION)); 
        move_uploaded_file($image['tmp_name'], $newFilePath);
        return $newFilePath;
    }*/
	
	public function getAttractionByName($name) {
        $query = $this->db->prepare("SELECT * FROM attractions WHERE name = ?");
        $query->execute([$name]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
}