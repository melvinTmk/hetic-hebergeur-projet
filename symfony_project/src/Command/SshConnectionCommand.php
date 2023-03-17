<?php
use phpseclib3\Net\SSH2;

class SshConnectionCommand
{
    private $host;
    private $username;
    private $password;
    private $ssh;
    private $database_name = 'my_new_database';
    private $create_database_command = 'mysql -u root -p -e "CREATE DATABASE ' . $database_name . ';"';
    private $result = $ssh->exec($create_database_command);
    
  
    public function __construct($host, $username, $password)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
    }

    public function connect()
    {
        $this->ssh = new SSH2($this->host);
        if (!$this->ssh->login($this->username, $this->password)) {
            throw new \RuntimeException('Unable to connect to SSH server');
        }
        else{
                echo 'SSH connection established successfully.';
        }
    }

    public function exec($command)
    {
        if (!$this->ssh) {
            throw new \RuntimeException('SSH connection not established');
        }

        $output = $this->ssh->exec($command);
        return $output;
    }

    public function dbConnexion($result){
        if ($result) {
            echo 'Database created successfully.';
        } else {
            echo 'Error creating database: ' . $ssh->getLastError();
        }
    }
}
