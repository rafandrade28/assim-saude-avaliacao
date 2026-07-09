<?php

namespace App\Models;

use Core\Model;
use PDOException;

class Cargo extends Model
{
    private ?int $id = null;
    private ?string $nome = null;
    private ?float $salario = null;
    private ?string $created_at = null;
    private ?string $updated_at = null;

    // --- Getters e Setters ---
    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): void { $this->id = $id; }

    public function getNome(): ?string { return $this->nome; }
    public function setNome(?string $nome): void { $this->nome = $nome; }

    public function getSalario(): ?float { return $this->salario; }
    public function setSalario(?float $salario): void { $this->salario = $salario; }

    public function getCreatedAt(): ?string { return $this->created_at; }
    public function setCreatedAt(?string $created_at): void { $this->created_at = $created_at; }

    public function getUpdatedAt(): ?string { return $this->updated_at; }
    public function setUpdatedAt(?string $updated_at): void { $this->updated_at = $updated_at; }

    // --- Métodos de Banco de Dados ---

    public function listar(): array
    {
        try {
            $stmt = $this->db->query("SELECT * FROM cargo ORDER BY id DESC");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Erro ao listar cargos: " . $e->getMessage());
            return [];
        }
    }

    public function buscarPorId(int $id): ?object
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM cargo WHERE id = ?");
            $stmt->execute([$id]);
            $resultado = $stmt->fetch();
            return $resultado ?: null;
        } catch (PDOException $e) {
            error_log("Erro ao buscar cargo: " . $e->getMessage());
            return null;
        }
    }

    public function pesquisarPorNome(string $nome): array
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM cargo WHERE nome LIKE ? ORDER BY id DESC");
            $stmt->execute(["%$nome%"]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Erro ao pesquisar cargos: " . $e->getMessage());
            return [];
        }
    }

    public function salvar(): bool
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO cargo (nome, salario) VALUES (?, ?)");
            return $stmt->execute([$this->nome, $this->salario]);
        } catch (PDOException $e) {
            error_log("Erro ao salvar cargo: " . $e->getMessage());
            return false;
        }
    }

    public function atualizar(): bool
    {
        try {
            $stmt = $this->db->prepare("UPDATE cargo SET nome = ?, salario = ? WHERE id = ?");
            return $stmt->execute([$this->nome, $this->salario, $this->id]);
        } catch (PDOException $e) {
            error_log("Erro ao atualizar cargo: " . $e->getMessage());
            return false;
        }
    }

    public function excluir(int $id): bool
    {
        // Não usamos try/catch aqui para permitir que o Controller capture a exceção 
        // de Foreign Key (RESTRICT) e exiba uma mensagem amigável ao usuário.
        $stmt = $this->db->prepare("DELETE FROM cargo WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
