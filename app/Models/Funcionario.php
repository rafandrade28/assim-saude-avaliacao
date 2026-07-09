<?php

namespace App\Models;

use Core\Model;
use PDOException;

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

    // --- Getters e Setters ---
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

    // --- Métodos de Banco de Dados ---

    public function listar(): array
    {
        try {
            $sql = "SELECT f.*, c.nome as cargo_nome 
                    FROM funcionario f 
                    JOIN cargo c ON f.cargoId = c.id 
                    ORDER BY f.id DESC";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Erro ao listar funcionários: " . $e->getMessage());
            return [];
        }
    }

    public function buscarPorId(int $id): ?object
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM funcionario WHERE id = ?");
            $stmt->execute([$id]);
            $resultado = $stmt->fetch();
            return $resultado ?: null;
        } catch (PDOException $e) {
            error_log("Erro ao buscar funcionário: " . $e->getMessage());
            return null;
        }
    }

    public function pesquisar(string $nome, string $cpf): array
    {
        try {
            $sql = "SELECT f.*, c.nome as cargo_nome 
                    FROM funcionario f 
                    JOIN cargo c ON f.cargoId = c.id 
                    WHERE f.nome LIKE ? AND f.cpf LIKE ? 
                    ORDER BY f.id DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(["%$nome%", "%$cpf%"]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Erro ao pesquisar funcionários: " . $e->getMessage());
            return [];
        }
    }

    public function salvar(): bool
    {
        try {
            $sql = "INSERT INTO funcionario (nome, dataNascimento, cep, logradouro, numero, complemento, bairro, municipio, uf, cpf, email, telefone, cargoId) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $this->nome, $this->dataNascimento, $this->cep, $this->logradouro, 
                $this->numero, $this->complemento, $this->bairro, $this->municipio, 
                $this->uf, $this->cpf, $this->email, $this->telefone, $this->cargoId
            ]);
        } catch (PDOException $e) {
            error_log("Erro ao salvar funcionário: " . $e->getMessage());
            return false;
        }
    }

    public function atualizar(): bool
    {
        try {
            $sql = "UPDATE funcionario SET 
                    nome = ?, dataNascimento = ?, cep = ?, logradouro = ?, numero = ?, 
                    complemento = ?, bairro = ?, municipio = ?, uf = ?, cpf = ?, 
                    email = ?, telefone = ?, cargoId = ? 
                    WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $this->nome, $this->dataNascimento, $this->cep, $this->logradouro, 
                $this->numero, $this->complemento, $this->bairro, $this->municipio, 
                $this->uf, $this->cpf, $this->email, $this->telefone, $this->cargoId, 
                $this->id
            ]);
        } catch (PDOException $e) {
            error_log("Erro ao atualizar funcionário: " . $e->getMessage());
            return false;
        }
    }

    public function excluir(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM funcionario WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
