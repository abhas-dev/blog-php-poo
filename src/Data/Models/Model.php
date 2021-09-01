<?php

namespace App\Data\Models;

abstract class Model
{
    /** @var array  */
    private $originalData = [];

    /**
     * @return array
     */
    public abstract static function metadata(): array;

    /**
     * Genere le nom du getter correspond au nom de la colonne bdd puis recupere la valeur dans le Model
     *
     * @param $column
     * @return string
     */
    public function getSQLValueByColumn($column)
    {
        // On recupere le getter
        $value = $this->{sprintf("get%s", ucfirst($this::metadata()["columns"][$column]["property"]))}();
        if($value instanceof \DateTimeImmutable){
            return $value->format("Y-m-d H:i:s");
        }
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
            throw new \Exception("Aucun resultat n'a été trouvé ! ");
        }
        $this->originalData = $datas;
        foreach($datas as $column => $value) {
            $this->hydrateProperty($column, $value);
        }
        if(property_exists($this, 'createdAt') && $this->createdAt === null)
        {
            //$createdAt = (new \DateTimeImmutable)->format(("d/m/Y H:i:s"));
            //$datetime = \DateTimeImmutable::createFromFormat("d/m/Y H:i:s", $createdAt);
            $this->setCreatedAt((new \DateTimeImmutable));
            //$this->{sprintf("set%s", ucfirst($this::metadata()["columns"][$column]["property"]))}($datetime);
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
                $datetime = \DateTimeImmutable::createFromFormat("Y-m-d H:i:s", $value);
                $this->{sprintf("set%s", ucfirst($this::metadata()["columns"][$column]["property"]))}($datetime);
                break;
        }
    }
    public function loadData($data)
    {

    }

    public function validate()
    {
    }
}