<?php

namespace App\Forms;

use App\Database;

abstract class Form
{
    protected const RULE_REQUIRED = 'required';
    protected const RULE_EMAIL = 'email';
    protected const RULE_MIN = 'min';
    protected const RULE_MAX = 'max';
    protected const RULE_MATCH = 'match';
    protected const RULE_UNIQUE = 'unique';
    protected const RULE_LOGIN = 'login';
    protected array $errors = [];

    /**
     * @return array
     */
    abstract public function rules(): array;

    /**
     * @return array
     */
    abstract public static function metadata(): array;

    public function objectifyForm($data): self
    {
        if(property_exists($this, 'createdAt'))
        {
            $datetime = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris'));
            $this->setCreatedAt($datetime);
        }
        foreach($data as $column => $value) {
            if($column !== 'token'){
                $this->objectifyFormProperty($column, $value);
            }
        }
        return $this;
    }

    /**
     * On "definie" le setter correspondant et on affecte la valeur
     *
     * @param string $column
     * @param mixed $value
     */
    private function objectifyFormProperty($column, $value): void
    {
        // On verifie le type de la data puis on appel le setter dynamiquement
        switch($this::metadata()["columns"][$column]["type"]) {
            case "integer":
                $this->{sprintf("set%s", ucfirst($this::metadata()["columns"][$column]["property"]))}((int) $value);
                break;
            case "string":
                $this->{sprintf("set%s", ucfirst($this::metadata()["columns"][$column]["property"]))}($value);
                break;
        }
    }

    public function validate()
    {
        // On parcours les regles etablies
        foreach ($this->rules() as $attribute => $rules)
        {
            $value = $this->$attribute;   //firstname,username,email...
            // On parcours chaque array de rule par attribut
            foreach ($rules as $rule)
            {
                // Si la regle n'est pas une string alors c'est un array on recupere le nom a l'index 0
                $ruleName = $rule;
                // Si ce n'est pas une string alors c'est un array et on prends la valeur 0 comme ruleName
                if(!is_string($ruleName))
                {
                    $ruleName = $rule[0];
                }
                // Si la regle est obligatoire et que la valeur n'a pas été entrée
                if($ruleName === self::RULE_REQUIRED && $value === '')
                {
                    // Alors on l'ajoute dans le tableau des erreurs
                    $this->addErrorByRule($attribute, self::RULE_REQUIRED);
                }

                if($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL))
                {
                    $this->addErrorByRule($attribute, self::RULE_EMAIL);
                }

                if($ruleName === self::RULE_MIN && strlen($value) < $rule['min'])
                {
                    $this->addErrorByRule($attribute, self::RULE_MIN, $rule);
                }

                if($ruleName === self::RULE_MAX && strlen($value) > $rule['max'])
                {
                    $this->addErrorByRule($attribute, self::RULE_MAX, $rule);
                }
                if($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']})
                {
                    $this->addErrorByRule($attribute, self::RULE_MATCH, $rule);
                }
                if($ruleName === self::RULE_UNIQUE)
                {
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName = $this->metadata()["table"];
                    $database = Database::getPDO();
                    $query = $database->prepare("SELECT * from $tableName WHERE $uniqueAttr = :attr");
                    $query->bindValue(":attr", $value);
                    $query->execute();
                    $data = $query->fetchObject();
                    if($data)
                    {
                        $this->addErrorByRule($attribute, self::RULE_UNIQUE);
                    }
                }
            }
        }
        return empty($this->errors);
    }

    public function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'Ce champs est requis',
            self::RULE_EMAIL => 'L\'adresse email n\'est pas valide',
            self::RULE_MIN => 'La longueur minimum doit etre {min}',
            self::RULE_MAX => 'La longueur maximum doit etre {max}',
            self::RULE_MATCH => "Ce champs doit etre identique au champ {match}",
            self::RULE_UNIQUE => 'Cette valeur est deja enregistrée',
            self::RULE_LOGIN => 'Ces valeurs ne correspondent à aucune entrée dans la base de donnée'
        ];
    }

    public function addErrorByRule(string $attribute, string $rule, array $params = [])
    {
        // On recupere le message d'erreur s'il existe sinon string vide
        $message = $this->errorMessages()[$rule] ?? '';
        foreach ($params as $key => $value)
        {
            $message = str_replace("{{$key}}", $value, $message);
        }
        // On l'ajoute dans des sous array avec pour clé l'attribut pour mettre plusieurs type d'erreurs
        $this->errors[$attribute][] = $message;
    }

    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute)
    {
        $errors = $this->errors[$attribute] ?? [];
        return $errors[0] ?? '';
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

}