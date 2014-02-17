<?php
namespace Authentication\Entity;

use User\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entity Class representing a Credential
 *
 * @ORM\Entity
 * @ORM\Table(name="credentials")
 */
class Credential
{
  
    
  /**
   * Primary Identifier
   * 
   * @ORM\Id
   * @ORM\Column(name="id", type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   * @var integer
   * @access protected
   */
  protected $pid;

  /**
   * UserID - foreign key to table user 
   *
   * @ORM\Column(name="uid", type="integer")
   * @var int
   * @access protected
   */
  protected $uid;
  
  /**
   * User Entity
   *
   * @ORM\OneToOne(targetEntity="User\Entity\User")
   * @ORM\JoinColumn(name="uid", referencedColumnName="uid")
   * @var User
   * @access protected
   */
   protected $user;
   
  /**
   * UserName
   *
   * @ORM\Column(name="username", type="string")
   * @var string
   * @access protected
   */
  protected $username;
  
  /**
   * password
   *
   * @ORM\Column(name="password", type="string")
   * @var string
   * @access protected
   */
  protected $password;
  
  /**
   * email
   *
   * @ORM\Column(name="email", type="string")
   * @var string
   * @access protected
   */
  protected $email;
  
  /**
   * created
   *
   * @ORM\Column(name="created", type="datetime")
   * @var DateTime
   * @access protected
   */
  protected $created;
  
  /**
   * verifyString
   *
   * @ORM\Column(name="verifyString", type="string")
   * @var string
   * @access protected
   */
  protected $verifyString;
  
  /**
   * verified
   *
   * @ORM\Column(name="verified", type="boolean")
   * @var bool
   * @access protected
   */
  protected $verified;
  
  /**
   * active
   *
   * @ORM\Column(name="active", type="boolean")
   * @var bool
   * @access protected
   */
  protected $active;
  
  /**
   * lastLogin
   *
   * @ORM\Column(name="lastLogin", type="datetime")
   * @var DateTime
   * @access protected
   */
  protected $lastLogin;
  
  /**
   * firstLogin
   *
   * @ORM\Column(name="firstLogin", type="datetime")
   * @var DateTime
   * @access protected
   */
  protected $firstLogin;
  
  /**
   * Constructor with optional array of properties.
   * Provide properties with key and value. Key is the 
   * name of the property without underline.
   * 
   *  
   * @param array $options
   */
  public function __construct(array $options = null)
  {
        if (is_array($options)) {
            $this->setOptions($options);
        }
  }

  /**
   * Sets the Identifier
   *
   * @param int $pid
   * @access public
   * @return User
   */
  public function setId($pid)
  {
    $this->pid = $pid;
    return $this;
  }

  /**
   * Returns the Identifier
   *
   * @access public
   * @return int
   */
  public function getId()
  {
    return $this->pid;
  }
  
  /**
   * Sets the UserID
   *
   * @param int $uid
   * @access public
   * @return Credential
   */
  public function setUid($uid)
  {
    $this->uid = $uid;
    return $this;
  }

  /**
   * Returns the UserID
   *
   * @access public
   * @return int
   */
  public function getUid()
  {
    return $this->uid;
  }

  /**
   * Sets the UserID
   *
   * @param int $user
   * @access public
   * @return User
   */
  public function setUser($user)
  {
    $this->user = $user;
    return $this;
  }

  /**
   * Returns the User
   *
   * @access public
   * @return User
   */
  public function getUser()
  {
    return $this->user;
  }

  /**
   * Sets the Username
   *
   * @param string $firstname
   * @access public
   * @return Credential
   */
  public function setUsername($firstname)
  {
    $this->username = $firstname;
    return $this;
  }

  /**
   * Returns the username
   *
   * @access public
   * @return string
   */
  public function getUsername()
  {
    return $this->username;
  }
  
  /**
   * Sets the password
   *
   * @param string $lastname
   * @access public
   * @return Credential
   */
  public function setPassword($lastname)
  {
    $this->password = $lastname;
    return $this;
  }

  /**
   * Returns the password
   *
   * @access public
   * @return string
   */
  public function getPassword()
  {
    return $this->password;
  }
  
  /**
   * Sets the email
   *
   * @param string $email
   * @access public
   * @return Credential
   */
  public function setEmail($email)
  {
    $this->email = $email;
    return $this;
  }

  /**
   * Returns the email
   *
   * @access public
   * @return string
   */
  public function getEmail()
  {
    return $this->email;
  }
  
  /**
   * Sets the verify string
   *
   * @param string $verify
   * @access public
   * @return Credential
   */
  public function setVerifyString($verify)
  {
    $this->verifyString = $verify;
    return $this;
  }

  /**
   * Returns the verify string
   *
   * @access public
   * @return string
   */
  public function getVerifyString()
  {
    return $this->verifyString;
  }
  
  /**
   * Sets the Date of creation
   *
   * @param string $datetime
   * @access public
   * @return Credential
   */
  public function setCreated($datetime)
  {
    $this->created = $datetime;
    return $this;
  }

  /**
   * Returns the Date  of creation
   *
   * @access public
   * @return DateTime
   */
  public function getCreated()
  {
    return $this->created;
  }
  
  
  /**
   * Sets the Date of the last Login
   *
   * @param string $datetime
   * @access public
   * @return Credential
   */
  public function setLastLogin($datetime)
  {
    $this->lastLogin = $datetime;
    return $this;
  }

  /**
   * Returns the Date of the last Login
   *
   * @access public
   * @return DateTime
   */
  public function getLastLogin()
  {
    return $this->lastLogin;
  }
  
  /**
   * Sets the Date of the first Login
   *
   * @param string $datetime
   * @access public
   * @return Credential
   */
  public function setFirstLogin($datetime)
  {
    $this->firstLogin = $datetime;
    return $this;
  }

  /**
   * Returns the Date of the first Login
   *
   * @access public
   * @return DateTime
   */
  public function getFirstLogin()
  {
    return $this->firstLogin;
  }
  
  /**
   * Sets active flag
   *
   * @param bool $active
   * @access public
   * @return Credential
   */
  public function setActive($active)
  {
    $this->active = $active;
    return $this;
  }

  /**
   * Returns the flag active
   *
   * @access public
   * @return bool
   */
  public function isActive()
  {
    
      return $this->active;
  }
  
  
  /**
   * Sets verified flag
   *
   * @param bool $verified
   * @access public
   * @return Credential
   */
  public function setVerified($verified)
  {
    $this->verified = $verified;
    return $this;
  }

  /**
   * Returns the flag verified
   *
   * @access public
   * @return bool
   */
  public function isVerified()
  {
    
      return $this->verified;
  }
  
  /**
   * Magical setter for convenience
   * 
   * @param type $name
   * @param type $value
   * @throws Exception
   */
  public function __set($name, $value)
  {
        $method = 'set' . $name;
        if (!method_exists($this, $method)) {
            throw new Exception('Invalid property');
        }
        $this->$method($value);
  }
 
  /**
   * Magical getter for convenience
   * 
   * @param type $name
   * @return type
   * @throws Exception
   */
  public function __get($name)
  {
        $method = 'get' . $name;
        if (!method_exists($this, $method)) {
            throw new Exception('Invalid property');
        }
        return $this->$method();
  }
 
  /**
   * Options may optionally passed on construction.
   * Sets properties by using key and data of an array.
   * 
   * @param array $options
   * @return \Authentication\Entity\Credential
   */
  public function setOptions(array $options)
  {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
  }
    
  /**
   * populating data as an array.
   * key of the array is getter methods name. 
   * 
   * @param array $data
   */
  
  public function populate($data) 
  {
       foreach($data as $key => $value) {
            
           $method = 'set'.ucfirst($key);
       
            if(method_exists($this, $method))
                $this->$method($value);
       }
       
  }
  
}