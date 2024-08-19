<?php

declare(strict_types=1);

namespace Faster\Model;

use Faster\Helper\Service;
use DateTime;
use Exception;
use Faster\Component\Enums\DataTypeEnum;
use Faster\Component\Enums\RuleEnum;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;

/**
 * FormModel
 * -----------
 * FormModel
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Model
 */
abstract class FormModel extends Model
{
    protected array $rules = [];
    protected array $messages = [
        RuleEnum::REQUIRED => 'Atribut {attribute} harus diisi',
        RuleEnum::EMAIL => 'Atribut {attribute} harus berisi alamat surel yang valid',
        RuleEnum::URL => 'Atribut {attribute} harus berisi alamat url yang valid',
        RuleEnum::IP => 'Atribut {attribute} harus berisi alamat ip yang valid',
        RuleEnum::LENGTH => 'Atribut {attribute} harus berisi karakter dengan panjang {length}',
        RuleEnum::MIN_LENGTH => 'Atribut {attribute} harus berisi karakter dengan panjang minimal {min_length}',
        RuleEnum::MAX_LENGTH => 'Atribut {attribute} harus berisi karakter dengan panjang maksimal {max_length}',
        RuleEnum::MATCH_FIELD => 'Atribut {attribute} harus berisi sama dengan isian pada atribute {match_field}',
        RuleEnum::NOT_MATCH_FIELD => 'Atribut {attribute} harus berisi berbeda dengan isian pada atribute {not_match_field}',
        RuleEnum::MATCH => 'Atribut {attribute} harus berisi sama dengan isian pada {match}',
        RuleEnum::NOT_MATCH => 'Atribut {attribute} harus berbeda dengan isian pada {not_match}',
        RuleEnum::CONTAINS => 'Atribut {attribute} harus mengandung isian {contains}',
        RuleEnum::NOT_CONTAINS => 'Atribut {attribute} harus tidak mengandung isian {not_contains}',
        RuleEnum::STARTS_WITH => 'Atribut {attribute} harus dimulai dengan isian {starts_with}',
        RuleEnum::ENDS_WITH => 'Atribut {attribute} harus diakhiri dengan isian {ends_with}',
        RuleEnum::NUMERIC => 'Atribut {attribute} harus berisi angka',
        RuleEnum::IN_LIST => 'Atribut {attribute} harus berisi salah satu dari {in_list}',
        RuleEnum::IN_RANGE => 'Atribut {attribute} harus berisi angka pada rentang {in_range}',
        RuleEnum::MIN => 'Atribut {attribute} harus berisi angka minimal {min}',
        RuleEnum::MAX => 'Atribut {attribute} harus berisi angka maksimal {max}',
        RuleEnum::DATE => 'Atribute {attribute} harus berisi tanggal dengan format {date}',
        RuleEnum::TIME => 'Atribute {attribute} harus berisi waktu dengan format {time}',
        RuleEnum::CAPTCHA => 'Atribute {attribute} tidak sesuai',
        RuleEnum::PASSWORD => 'Atribute {attribute} harus berisi huruf besar, huruf kecil, angka, karakter khusus, dan panjangnya minimal 6 huruf'
    ];
    protected bool $skipValidation;
    protected array $errors = [];
    protected array $labels = [];

    /**
     * __construct
     *
     * @param  string $name
     * @param  string $defaultAttribute
     * @param  bool $isEdit
     * @return void
     */
    public function __construct(private string $name, private string $defaultAttribute, private bool $isEdit = false)
    {
        $this->skipValidation = false;
    }
    /**
     * addProperty
     *
     * @param  string $property
     * @param  string $type
     * @param  null|string|array $rule
     * @param  string|null $label
     * @param  mixed $defaultValue
     * @return void
     */
    public function addProperty(string $property, string $type = DataTypeEnum::STRING, $rule = null, string|null $label = null, mixed $defaultValue = null): void
    {
        $this->types[$property] = $type;
        $this->storage[$property] = $defaultValue;
        if (!empty($rule)) {
            $this->rules[$property] = $rule;
        }
        if (!empty($label)) {
            $this->labels[$property] = $label;
        }
    }
    /**
     * getName
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    /**
     * isEdit
     *
     * @return bool
     */
    public function isEdit(): bool
    {
        return $this->isEdit;
    }
    /**
     * isCsrfEnabled
     *
     * @return bool
     */
    public function isCsrfEnabled(): bool
    {
        return config('security.csrf.enable');
    }    
    /**
     * csrfTokenName
     *
     * @return string
     */
    public function csrfTokenName(): string
    {
        return config('security.csrf.name');
    }
    /**
     * setRule
     *
     * @param  string $attribute
     * @param  null|string|array $rule
     * @return void
     */
    public function setRule(string $attribute, null|string|array $rule): void
    {
        if (property_exists($this, $attribute)) {
            $this->rules[$attribute] = $rule;
        }
    }
    /**
     * setLabel
     *
     * @param  string $attribute
     * @param  string $label
     * @return void
     */
    public function setLabel(string $attribute, string $label): void
    {
        if (property_exists($this, $attribute)) {
            $this->labels[$attribute] = $label;
        }
    }
    /**
     * getLabel
     *
     * @param  string $attribute
     * @return string
     */
    public function getLabel(string $attribute): string
    {
        return $this->labels[$attribute] ?? $attribute;
    }
    /**
     * setMessage
     *
     * @param  string $rule
     * @param  string $message
     * @return void
     */
    public function setMessage(string $rule, string $message): void
    {
        $this->messages[$rule] = $message;
    }

    /**
     * skipValidation
     *
     * @param  bool $skip
     * @return void
     */
    public function skipValidation(bool $skip = true): void
    {
        $this->skipValidation = $skip;
    }

    /**
     * fill and validate data from request GET and POST and with security csrf_token check
     *
     * @param  ServerRequestInterface $request
     * @return bool
     */
    public function fillAndValidateWith(ServerRequestInterface $request): bool
    {
        $data = Service::sanitize($request);

        return $this->fillAndValidate($data);
    }
    /**
     * fill and validate from array data with security csrf_token check
     *
     * @param  array $data
     * @return bool
     */
    public function fillAndValidate(array $data): bool
    {
        $this->fill($data);

        if ($this->isCsrfEnabled()) {

            if ($this->skipValidation) {
                return true;
            }
            $csrf_token = $data[$this->csrfTokenName()] ?? '';
            if (!$csrf_token || Service::session()->validateCsrfToken($this->name, $csrf_token) === false) {
                $this->addError('Csrf token tidak tersedia/tidak valid');
                return false;
            }
        }

        return $this->validate();
    }
    /**
     * validate form without security csrf_token check
     *
     * @return bool
     */
    public function validate(): bool
    {
        if ($this->skipValidation) {
            return true;
        }

        foreach ($this->rules as $attr => $rule) {

            $val = $this->getProperty($attr, '');
            if (is_string($rule)) {
                $rule = [$rule];
            } elseif (is_array($rule)) {
                if (is_string($rule[0]) && $this->isRuleHasParams($rule[0])) {
                    $rule = [$rule];
                }
            }

            foreach ($rule as $innerRule) {

                if (is_array($innerRule)) {
                    $ruleName = array_shift($innerRule);
                    $ruleParam = $innerRule;
                } elseif (is_string($innerRule)) {
                    $ruleName = $innerRule;
                    $ruleParam = '';
                } else {
                    throw new InvalidArgumentException('Rule definition not valid.');
                }

                switch ($ruleName) {
                    case RuleEnum::REQUIRED:
                        if (!$val) {
                            $this->addErrorForRule($ruleName, $attr);
                            return false;
                        }
                        break;
                    case RuleEnum::CAPTCHA:
                        if (Service::session()->validateCaptcha($this->name, $val) === false) {
                            $this->addErrorForRule($ruleName, $attr);
                            return false;
                        }
                        break;
                    case RuleEnum::EMAIL:
                        if (filter_var($val, FILTER_VALIDATE_EMAIL) === false) {
                            $this->addErrorForRule($ruleName, $attr);
                            return false;
                        }
                        break;
                    case RuleEnum::URL:
                        if (filter_var($val, FILTER_VALIDATE_URL) === false) {
                            $this->addErrorForRule($ruleName, $attr);
                            return false;
                        }
                        break;
                    case RuleEnum::IP:
                        if (filter_var($val, FILTER_VALIDATE_IP) === false) {
                            $this->addErrorForRule($ruleName, $attr);
                            return false;
                        }
                        break;
                    case RuleEnum::PASSWORD:
                        $uppercase = preg_match('@[A-Z]@', $val);
                        $lowercase = preg_match('@[a-z]@', $val);
                        $number    = preg_match('@[0-9]@', $val);
                        $specialChars = preg_match('@[^\w]@', $val);
                        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($val) < 6) {
                            $this->addErrorForRule($ruleName, $attr);
                            return false;
                        }
                        break;
                    case RuleEnum::LENGTH:
                        $param = $ruleParam[0];
                        if (strlen($val) !== intval($param)) {
                            $this->addErrorForRule($ruleName, $attr, $param);
                            return false;
                        }
                        break;
                    case RuleEnum::MIN_LENGTH:
                        $param = $ruleParam[0];
                        if (strlen($val) < intval($param)) {
                            $this->addErrorForRule($ruleName, $attr, $param);
                            return false;
                        }
                        break;
                    case RuleEnum::MAX_LENGTH:
                        $param = $ruleParam[0];
                        if (strlen($val) > intval($param)) {
                            $this->addErrorForRule($ruleName, $attr, $param);
                            return false;
                        }
                        break;
                    case RuleEnum::MATCH_FIELD:
                        $param = $ruleParam[0];
                        if ($val !== $this->getProperty($param)) {
                            $this->addErrorForRule($ruleName, $attr, $this->getLabel($param));
                            return false;
                        }
                        break;
                    case RuleEnum::NOT_MATCH_FIELD:
                        $param = $ruleParam[0];
                        if ($val === $this->getProperty($param)) {
                            $this->addErrorForRule($ruleName, $attr, $this->getLabel($param));
                            return false;
                        }
                        break;
                    case RuleEnum::MATCH:
                        $param = $ruleParam[0];
                        if ($val !== $param) {
                            $this->addErrorForRule($ruleName, $attr, $param);
                            return false;
                        }
                        break;
                    case RuleEnum::NOT_MATCH:
                        $param = $ruleParam[0];
                        if ($val === $param) {
                            $this->addErrorForRule($ruleName, $attr, $param);
                            return false;
                        }
                        break;
                    case RuleEnum::CONTAINS:
                        $param = $ruleParam[0];
                        if (str_contains($val, $param) === false) {
                            $this->addErrorForRule($ruleName, $attr, $param);
                            return false;
                        }
                        break;
                    case RuleEnum::NOT_CONTAINS:
                        $param = $ruleParam[0];
                        if (str_contains($val, $param) === true) {
                            $this->addErrorForRule($ruleName, $attr, $param);
                            return false;
                        }
                        break;
                    case RuleEnum::STARTS_WITH:
                        $param = $ruleParam[0];
                        if (str_starts_with($val, $param) === false) {
                            $this->addErrorForRule($ruleName, $attr, $param);
                            return false;
                        }
                        break;
                    case RuleEnum::ENDS_WITH:
                        $param = $ruleParam[0];
                        if (str_ends_with($val, $param) === false) {
                            $this->addErrorForRule($ruleName, $attr, $param);
                            return false;
                        }
                        break;
                    case RuleEnum::NUMERIC:
                        if (is_numeric($val) === false) {
                            $this->addErrorForRule($ruleName, $attr);
                            return false;
                        }
                        break;
                    case RuleEnum::IN_LIST:
                        $param = $ruleParam[0];
                        if (in_array($val, $param) === false) {
                            $this->addErrorForRule($ruleName, $attr, '[' . implode(' atau ', $param) . ']');
                            return false;
                        }
                        break;
                    case RuleEnum::IN_RANGE:
                        $min = floatval($ruleParam[0]);
                        $max = floatval($ruleParam[1]);
                        $v = floatval($val);
                        if ($v > $max || $v < $min) {
                            $this->addErrorForRule($ruleName, $attr, '[' . strval($min) . ',' . strval($max) . ']');
                            return false;
                        }
                        break;
                    case RuleEnum::MAX:
                        $max = $ruleParam[0];
                        if (floatval($val) > floatval($max)) {
                            $this->addErrorForRule($ruleName, $attr, $max);
                            return false;
                        }
                        break;
                    case RuleEnum::MIN:
                        $min = $ruleParam[0];
                        if (floatval($val) < floatval($min)) {
                            $this->addErrorForRule($ruleName, $attr, $min);
                            return false;
                        }
                        break;
                    case RuleEnum::DATE:
                        if (DateTime::createFromFormat('Y-m-d', $val) === false) {
                            $this->addErrorForRule($ruleName, $attr);
                            return false;
                        }
                        break;
                    case RuleEnum::TIME:
                        if (strtotime($val) === false) {
                            $this->addErrorForRule($ruleName, $attr);
                            return false;
                        }
                        break;
                    default:
                        throw new Exception("Rule {$ruleName} for attribute {$attr} not found or configured properly.");
                }
            }
        }

        return !$this->hasError();
    }
    /**
     * isRuleHasParams
     *
     * @param  string $ruleName
     * @return bool
     */
    protected function isRuleHasParams(string $ruleName): bool
    {
        $ruleNameWithParams = [
            RuleEnum::LENGTH,
            RuleEnum::MIN_LENGTH,
            RuleEnum::MAX_LENGTH,
            RuleEnum::MATCH_FIELD,
            RuleEnum::NOT_MATCH_FIELD,
            RuleEnum::MATCH,
            RuleEnum::NOT_MATCH,
            RuleEnum::CONTAINS,
            RuleEnum::NOT_CONTAINS,
            RuleEnum::STARTS_WITH,
            RuleEnum::ENDS_WITH,
            RuleEnum::NUMERIC,
            RuleEnum::IN_LIST,
            RuleEnum::IN_RANGE,
            RuleEnum::MIN,
            RuleEnum::MAX,
            RuleEnum::DATE
        ];
        
        return in_array($ruleName, $ruleNameWithParams);
    }
    /**
     * addErrorForRule
     *
     * @param  string $rule
     * @param  string $attribute
     * @param  mixed $param
     * @return void
     */
    protected function addErrorForRule(string $rule, string $attribute, mixed $param = null): void
    {
        $message = $this->messages[$rule] ?? '';
        if (!empty($message)) {
            $message = str_replace("{attribute}", $this->getLabel($attribute), $message);
            $message = str_replace("{{$rule}}", strval($param ?? ''), $message);
        }
        $this->addError($message, $attribute);
    }
    /**
     * addError
     *
     * @param  string $message
     * @param  string|null $attribute
     * 
     * @return void
     */
    public function addError(string $message, string|null $attribute = null): void
    {
        $attribute = $attribute ?? $this->defaultAttribute;
        $this->errors[$attribute][] = $message;
    }
    /**
     * hasError
     *
     * @param  string|null $attribute
     * @return bool
     */
    public function hasError(string|null $attribute = null): bool
    {
        if (is_null($attribute)) {
            return !empty($this->errors);
        }

        return !empty($this->errors[$attribute]);
    }
    /**
     * firstError
     *
     * @param  string|null $attribute
     * @return string|array
     */
    public function firstError(string|null $attribute = null)
    {
        if ($attribute === null) {
            $message = [];
            foreach ($this->errors as $attr => $msg) {
                $message[] = $msg[0];
            }
            return $message;
        }
        return $this->errors[$attribute][0] ?? '';
    }
    /**
     * getError
     *
     * @param  string|null $attribute
     * @return array
     */
    public function getError(string|null $attribute = null): array
    {
        if ($attribute === null) {
            $message = [];
            foreach ($this->errors as $attr => $msg) {
                $message[] = $msg;
            }
            return $message;
        }

        return $this->errors[$attribute] ?? [];
    }
}
