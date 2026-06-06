<?php
// setup.php

// Puxa a nossa classe de banco de dados
require_once __DIR__ . '/../app/core/Database.php';

echo "Iniciando a criação das tabelas...<br>";

try {
    // Conecta ao banco
    $db = Database::connect();

    // 1. Tabela de Usuários (Clientes, Corretores e Admins)
    $queryUsers = "
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nome TEXT NOT NULL,
            email TEXT NOT NULL UNIQUE,
            senha TEXT NOT NULL,
            role TEXT NOT NULL DEFAULT 'cliente',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ";
    // Executa o comando
    $db->exec($queryUsers);
    echo "- Tabela 'users' criada com sucesso.<br>";

    // 2. Tabela de Imóveis
    $queryImoveis = "
        CREATE TABLE IF NOT EXISTS imoveis (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            titulo TEXT NOT NULL,
            descricao TEXT,
            preco REAL NOT NULL,
            corretor_id INTEGER NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (corretor_id) REFERENCES users(id)
        )
    ";
    $db->exec($queryImoveis);
    echo "- Tabela 'imoveis' criada com sucesso.<br>";

    // BÔNUS: Inserindo um usuário Corretor (Admin) de teste
    // Usamos password_hash para não salvar a senha em texto puro!
    $senhaCriptografada = password_hash('123456', PASSWORD_DEFAULT);
    
    // Ignora a inserção se o e-mail já existir (para não dar erro rodando 2 vezes)
    $db->exec("
        INSERT OR IGNORE INTO users (nome, email, senha, role) 
        VALUES ('Corretor Master', 'admin@imobiliaria.com', '$senhaCriptografada', 'admin')
    ");
    echo "- Usuário de teste inserido.<br>";

    echo "<b>Setup do banco finalizado com sucesso!</b>";

} catch (PDOException $e) {
    echo "<b>Erro durante a criação:</b> " . $e->getMessage();
}
?>