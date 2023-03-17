<?php

namespace App\Command;

use phpseclib3\Net\SSH2;

class SshConnectionCommand
{
    private $host;
    private $username;
    private $password;
    private $ssh;
   
  
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
        // else{
        //     echo 'SSH connection established successfully.';
        // }
    }

    public function exec($command)
    {
        if (!$this->ssh) {
            throw new \RuntimeException('SSH connection not established');
        }

        $output = $this->ssh->exec($command);
        return $output;
    }

  
}
