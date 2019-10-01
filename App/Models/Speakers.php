<?php
    namespace App\Models;

    class Speakers extends Model {
        protected $table = "speakers";

        public $id;
        public $name;
        public $img_path;
        public $description;

        public function create(){
            $sql = "INSERT INTO speakres set
                name = :name,
                description = :description,
                img_path = :img_path
            ";

            $query = SELF::conn()->prepare($sql);
            $success = $query->execute([
                'name' => $this->name,
                'description' => $this->description,
                'img_path' => $this->img_path
            ]);

            $this->id = SELF::conn()->lastInsertId();
            return $success;
        }

        public function update(){
            $sql = "UPDATE speakers set
                name = :name,
                description = :description,
                $img_path = :img_path
                WHERE id = :userId"
        }
    }
?>