<?php
    namespace App\Models;

    class Speaker extends Model {
        protected $table = "speakers";

        public $id;
        public $name;
        public $img_path;
        public $fk_events;
        public $description;

        public function create(){
            $sql = "INSERT INTO speakers set
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

        public function update() {
            $sql = "UPDATE speakers set
                name = :name,
                description = :description,
                $img_path = :img_path
                WHERE id = :userId";
            
            $query = SELF::conn()->prepare($sql);

            $success = $query->execute([
                'name' => $this->name, 
                'description' => $this->description,
                'img_path' => $this->img_path,
                'fk_events' => $this->fk_events
            ]);
        }

        public function findAll(){
            return SELF::getInstancesByQuery("SELECT * FROM speakers ORDER BY name ASC");
        }
        
        public static function newByData ($data) {
            $data = (object) $data;
            $speaker = new SELF();
            $speaker->id = $data->id;
            $speaker->name = $data->name;
            $speaker->description = $data->description;
            $speaker->img_path = $data->img_path;
            return $speaker;
        }

        public static function findById($id) {
            $sql = "SELECT * FROM speakers WHERE id = :id";
            $query = SELF::conn()->prepare($sql);

            $query->execute([
                'id' => $id
            ]);

            $raw = $query->fetch();

            return SELF::newByData($raw);
        }

        private static function getInstancesByQuery($sql) {
            $list = [];
            $query = SELF::conn()->prepare($sql);
            
            if ($query->execute()) {	
                while ($raw = $query->fetch()) {
                    $list[] = SELF::newByData($raw);
                }
            }
            
            return $list;
        }


    }
?>