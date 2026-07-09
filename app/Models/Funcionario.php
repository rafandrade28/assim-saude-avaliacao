<?php

namespace App\Models;

use Core\Model;

class Funcionario extends Model
{
    private ?int $id = null;
    private ?string $nome = null;
    private ?string $dataNascimento = null;
    private ?string $cep = null;
    private ?string $logradouro = null;
    private ?string $numero = null;
    private ?string $complemento = null;
    private ?string $bairro = null;
    private ?string $municipio = null;
    private ?string $uf = null;
    private ?string $cpf = null;
    private ?string $email = null;
    private ?string $telefone = null;
    private ?int $cargoId = null;
    private ?string $created_at = null;
    private ?string $updated_at = null;

    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): void { $this->id = $id; }

    public function getNome(): ?string { return $this->nome; }
    public function setNome(?string $nome): void { $this->nome = $nome; }

    public function getDataNascimento(): ?string { return $this->dataNascimento; }
    public function setDataNascimento(?string $dataNascimento): void { $this->dataNascimento = $dataNascimento; }

    public function getCep(): ?string { return $this->cep; }
    public function setCep(?string $cep): void { $this->cep = $cep; }

    public function getLogradouro(): ?string { return $this->logradouro; }
    public function setLogradouro(?string $logradouro): void { $this->logradouro = $logradouro; }

    public function getNumero(): ?string { return $this->numero; }
    public function setNumero(?string $numero): void { $this->numero = $numero; }

    public function getComplemento(): ?string { return $this->complemento; }
    public function setComplemento(?string $complemento): void { $this->complemento = $complemento; }

    public function getBairro(): ?string { return $this->bairro; }
    public function setBairro(?string $bairro): void { $this->bairro = $bairro; }

    public function getMunicipio(): ?string { return $this->municipio; }
    public function setMunicipio(?string $municipio): void { $this->municipio = $municipio; }

    public function getUf(): ?string { return $this->uf; }
    public function setUf(?string $uf): void { $this->uf = $uf; }

    public function getCpf(): ?string { return $this->cpf; }
    public function setCpf(?string $cpf): void { $this->cpf = $cpf; }

    public function getEmail(): ?string { return $this->email; }
    public function setEmail(?string $email): void { $this->email = $email; }

    public function getTelefone(): ?string { return $this->telefone; }
    public function setTelefone(?string $telefone): void { $this->telefone = $telefone; }

    public function getCargoId(): ?int { return $this->cargoId; }
    public function setCargoId(?int $cargoId): void { $this->cargoId = $cargoId; }

    public function getCreatedAt(): ?string { return $this->created_at; }
    public function setCreatedAt(?string $created_at): void { $this->created_at = $created_at; }

    public function getUpdatedAt(): ?string { return $this->updated_at; }
    public function setUpdatedAt(?string $updated_at): void { $this->updated_at = $updated_at; }
}
