<?php
class Validate
{
    private $_passed = false,
            $_errors = array(),
            $_db = null;

    public function __construct()
    {
        $this->_db = DB::getInstance();
    }

    public function check($source, $items = array())
    {
        foreach($items as $item => $rules)
        {
            foreach($rules as $rule => $rule_value)
            {
                $userInput = trim($source[$item]);
                $item = escape($item);

                if($rule === 'required' && empty($userInput))
                {
                    $this->addError("$item is required");
                }
                else if(!empty($userInput))
                {
                    switch($rule)
                    {
                        case 'min':
                            if(strlen($userInput) < $rule_value)
                            {
                                $this->addError("$item must be at least $rule_value characters");
                            }
                        break;
                        case 'max':
                            if(strlen($userInput) > $rule_value)
                            {
                                $this->addError("$item must be at less than $rule_value characters");
                            }
                        break;
                        case 'matches':
                            if($userInput != $source[$rule_value])
                            {
                                $this->addError("Password doesn't match");
                            }
                        break;
                        case 'unique':
                            $check = $this->_db->get($rule_value,array($item,'=',$userInput));
                            if($check->count())
                            {
                                $this->addError("$item already exists!");
                            }
                        break;
                    }
                }
                
            }
        }
        if(empty($this->_errors))
        {
            $this->_passed= true;
        }
        return $this;
    }

    public function addError($error)
    {
        $this->_errors[] = $error;
    }

    public function errors()
    {
        return $this->_errors;
    }

    public function passed()
    {
        return $this->_passed;
    }
}