<?php
    namespace App\Models;

    class Speaker extends Model {
        protected $table = "speakers";

        public $id;
        public $name;
        public $description;
        public $img_path;
        public $fk_event;
        private $event;

        public function create(){
            $sql = "INSERT INTO speakers set
                name = :name,
                description = :description,
                img_path = :img_path,
                fk_event = :fk_event
            ";

            $query = SELF::conn()->prepare($sql);
            $success = $query->execute([
                'name' => $this->name,
                'description' => $this->description,
                'img_path' => $this->img_path,
                'fk_event' => $this->fk_event
            ]);

            $this->id = SELF::conn()->lastInsertId();
            return $success;
        }

        public function update() {
            $sql = "UPDATE speakers set
                name = :name,
                description = :description,
                img_path = :img_path,
                fk_event = :fk_event
                WHERE id = :id";
            
            $query = SELF::conn()->prepare($sql);

            $success = $query->execute([
                'name' => $this->name, 
                'description' => $this->description,
                'img_path' => $this->img_path,
                'fk_event' => $this->fk_event,
                'id' => $this->id
            ]);
        }

        public function getEvent() {
            if (!isset($this->event)) {
                $this->event = Event::findById($this->fk_event);
            }
            return $this->event;
        }

        public function findAll(){
            return SELF::getInstancesByQuery("SELECT * FROM speakers ORDER BY name ASC");
        }

        public function findByEvent ($event) {
            return SELF::getInstancesByQuery(
                "SELECT * FROM speakers WHERE fk_event = :fk_event ORDER BY name ASC",
                ['fk_event' => $event->id]
            );
        }
        
        public static function newByData ($data) {
            $data = (object) $data;
            $speaker = new SELF();
            $speaker->id = $data->id;
            $speaker->name = $data->name;
            $speaker->description = $data->description;
            $speaker->img_path = $data->img_path;
            $speaker->fk_event = $data->fk_event;
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

        private static function getInstancesByQuery($sql, $data = []) {
            $list = [];
            $query = SELF::conn()->prepare($sql);
            
            if ($query->execute($data)) {	
                while ($raw = $query->fetch()) {
                    $list[] = SELF::newByData($raw);
                }
            }
            
            return $list;
        }


    }
?>