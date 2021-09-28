<?php

namespace App\Data\Models;


use App\Database;
use App\Forms\Form;

abstract class Model
{

    /** @var array  */
    private $originalData = [];

    /**
     * @return array
     */
    abstract public static function metadata(): array;

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param $value
     */
    public function setPrimaryKey($value)
    {
        $this->hydrateProperty($this->metadata()["primaryKey"], $value);
    }

    /**
     * @return mixed
     */
    public function getPrimaryKey()
    {
        $primaryKeyColumn = $this->metadata()["primaryKey"];
        $property = $this->metadata()["columns"][$primaryKeyColumn]["property"];
        return $this->{sprintf("get%s", ucfirst($property))}();
    }

    /**
     * Genere le nom du getter correspond au nom de la colonne bdd puis recupere la valeur dans le Model
     *
     * @param $column
     * @return string
     */
    public function getSQLValueByColumn($column)
    {
        if($column === 'created_at' || $column === 'updated_at'){
            $value = $this->{sprintf("get%s", ucfirst($this::metadata()["columns"][$column]["property"]))}();
            return $value?->format("Y-m-d H:i:s");
        }
        $value = $this->{sprintf("get%s", ucfirst($this::metadata()["columns"][$column]["property"]))}();
        return $value;
    }

    /**
     * On save le resultat dans la proprieté et on boucle pour hydrater
     *
     * @param $result
     * @return $this
     * @throws \Exception
     */
    public function hydrate($datas): self
    {
        if(empty($datas)){
            throw new \Exception("Les données sont incorrects ! ");
        }
        $this->originalData = $datas;
        foreach($datas as $column => $value) {
            $this->hydrateProperty($column, $value);
        }
        return $this;
    }

    /**
     * On "definie" le setter correspondant et on affecte la valeur
     *
     * @param string $column
     * @param mixed $value
     */
    private function hydrateProperty($column, $value): void
    {
        // On verifie le type de la data puis on appel le setter dynamiquement
        switch($this::metadata()["columns"][$column]["type"]) {
            case "integer":
                $this->{sprintf("set%s", ucfirst($this::metadata()["columns"][$column]["property"]))}((int) $value);
                break;
            case "string":
                $this->{sprintf("set%s", ucfirst($this::metadata()["columns"][$column]["property"]))}($value);
                break;
            case "datetime":
                if($value)
                {
                    $datetime = \DateTimeImmutable::createFromFormat("Y-m-d H:i:s", $value);
                    $this->{sprintf("set%s", ucfirst($this::metadata()["columns"][$column]["property"]))}($datetime);
                }
                break;
        }
    }
}
