<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class RegistrationForm extends Model
{
    public $firstname;
    public $lastname;
    public $gender;
    public $day;
    public $month;
    public $year;
    public $phoneCode;
    public $phone;
    public $email;
    public $password;

    private $_user = false;

    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';

    const GENDERS = [
        self::GENDER_MALE,
        self::GENDER_FEMALE
    ];

    const COUNTRY_PHONE_CODES = [
        '374',
        '355',
        '7'
    ];

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['firstname', 'lastname', 'gender', 'day', 'month', 'year', 'phoneCode', 'email', 'phone', 'password'], 'required'],
            [['firstname', 'lastname'], 'match', 'pattern' => '#^[\w-]+$#is'],
            ['firstname', 'string', 'min' => 2, 'max' => 30],
            ['lastname', 'string', 'min' => 3, 'max' => 50],
            ['gender', 'in', 'range' => array_keys(self::GENDERS)],
            [['day', 'month', 'year'], 'integer'],
            ['phoneCode', 'in', 'range' => self::COUNTRY_PHONE_CODES],
            ['phone','string', 'max' => 14, 'min' => 4],
            ['phone', 'match', 'pattern' => '#^\d*$#is'],
            ['email', 'email'],
            ['password', 'string', 'min' => 6],
            ['email', 'unique', 'targetClass' => 'app\models\User']
        ];
    }

    /**
     * Logs in a user using the provided email and password.
     * @return bool whether the user is logged in successfully
     */
    public function register()
    {
        if (!$this->validate()) {
            return false;
        }
        if(User::findByPhoneNumber($this->phoneCode, $this->phone)){
            $this->addError('phone_number', 'Phone number already using');
            return false;
        }
        $user = new User();
        $user->firstname = $this->firstname;
        $user->lastname = $this->lastname;
        $user->gender = $this->gender;
        $user->birthdate = $this->generateBirthday();
        $user->email = $this->email;
        $user->phone_code = $this->phoneCode;
        $user->phone = $this->phone;
        $user->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        $user->password_reset_token = Yii::$app->getSecurity()->generatePasswordHash($this->email);
        $user->email_confirm_token = Yii::$app->getSecurity()->generatePasswordHash($this->email);
        if($user->save()){
            return Yii::$app->user->login($user,0);
        }
        return false;
    }


    public function generateBirthday()
    {
        return $this->year . '-' . ++$this->month . '-' . ++$this->day . ' 00:00:00';
    }

}
