<?php

namespace App\Data\Managers;

use App\Data\Models\Model;
use App\Database;
use PDO;

abstract class Manager{

    /** @var string  */
    protected string $table;

    /** @var PDO  */
    private PDO $database;

    /** @var string  */
    protected string $modelName;

    /** @var array  */
    private array $metadata;


    public function __construct()
    {
        $this->database = Database::getPDO();

//        $modelName =  str_replace("App\Data\Managers\\", "", get_class($this));
//        $modelName = 'App\Data\Models\\' . str_replace("Manager", "", $modelName) . "Model";
        $this->modelName = $this->getModelName();

        $this->metadata = $this->modelName::metadata();
    }

    abstract public function getModelName();

    /**
     * Requete en bdd et retourne un tableau d'objet Model
     *
     * @return array
     */
    public function findAll(): array
    {
        $query = $this->createQuery('SELECT * FROM ' . $this->table . ' ORDER BY created_at DESC');
        $datas = $query->fetchAll();
        $result = [];

        foreach ($datas as $data){

            $result[] = (new $this->modelName)->hydrate($data);
        }
        return $result;
    }

    public function find(int $id): Model
    {
        $sql = "SELECT * FROM $this->table WHERE id = ?";
        $query = $this->createQuery($sql, [$id]);
        $data = $query->fetchObject();
        return (new $this->modelName)->hydrate($data);
    }

    public function findBy(array $arguments): ?Model
    {
        $keys = [];
        $values = [];

        // On boucle pour eclater le tableau
        foreach ($arguments as $key => $value){
            $keys[] = "$key = ?";
            $values[] = $value;
        }

        // On transforme le tableau "keys" en une string
        $keyList = implode(' AND ', $keys);

        // On execute la requete
        $sql = "SELECT * FROM $this->table WHERE $keyList";
        $query = $this->createQuery($sql, $values);
        //$query->fetchAll(PDO::FETCH_CLASS, $modelName)    Hydratation par PDO

        $data = $query->fetchAll();
        return (new $this->modelName)->hydrate($data);
    }

    public function save(Model &$model)
    {
        // Exemple: INSERT INTO annonces (titre,description,actif) VALUES(?,?,?)
        $champs = [];
        $question = [];
        $values = [];
        foreach(array_keys($this->metadata["columns"]) as $column)
        {

            // On rempli les ? dans un array
            $question[] = "?";
            // On recupere les getters puis la valeur
            $sqlValue = $model->getSQLValueByColumn($column);
            // On enregistre les datas qu'on va mettre en bdd dans un array
            $model->orignalData[$column] = $sqlValue;
            // On mets les valeurs dans un array
            $values[] = $sqlValue;
            // On enregistre le nom des champs
            $champs[] = $column;

        }
        $sql = sprintf("INSERT INTO %s (%s) VALUES (%s)", $this->metadata["table"], implode(', ', $champs), implode(", ", $question));
        $model->setPrimaryKey($this->database->lastInsertId());

        return $query = $this->createQuery($sql, $values);
    }


    public function update(int $id, Manager $model){
        $keys = [];
        $values = [];

        // On boucle pour eclater le tableau
        foreach($model as $key => $value){
            // UPDATE annonces SET titre = ?,description = ?,actif = ? WHERE id = ?
            if($value !== null && $key != 'db' && $key != 'table'){
                $keys[] = "$key = ?";
                $values[] = $value;
            }
        }

        $values[] = $id;
        // On transforme le tableau "keys" en une string
        $keyList = implode(', ', $keys);

        // On execute la requete
        $sql = "UPDATE $this->table SET $keyList WHERE id = ?";
        return $query = $this->createQuery($sql, $values);
    }

    public function delete(int $id){
        return $this->createQuery("DELETE FROM $this->table WHERE id = ?", [$id]);
    }

    protected function createQuery(string $sql, array $params = [])
    {
        if(!$params){
            return $this->database->query($sql);
        }

        $query = $this->database->prepare($sql);
        $query->execute($params);
        return $query;
    }


}