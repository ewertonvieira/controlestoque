CREATE DATABASE IF NOT EXISTS controle_estoque;
USE controle_estoque;

-- Tabela de Categorias
CREATE TABLE Categoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
);

-- Tabela de Produtos
CREATE TABLE Produto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    sku VARCHAR(50) UNIQUE NOT NULL,
    preco DECIMAL(15,2) NOT NULL,
    estoque INT NOT NULL,
    estoque_minimo INT NOT NULL,
    categoria_id INT,
    FOREIGN KEY (categoria_id) REFERENCES Categoria(id) ON DELETE SET NULL
);

-- Tabela de Fornecedores
CREATE TABLE Fornecedor (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    contato VARCHAR(100),
    email VARCHAR(100) UNIQUE NOT NULL
);

-- Tabela de Compras
CREATE TABLE Compra (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fornecedor_id INT NOT NULL,
    data DATE NOT NULL,
    total DECIMAL(20,2) NOT NULL,
    FOREIGN KEY (fornecedor_id) REFERENCES Fornecedor(id) ON DELETE CASCADE
);

-- Tabela de Itens da Compra
CREATE TABLE ItemCompra (
    id INT AUTO_INCREMENT PRIMARY KEY,
    compra_id INT NOT NULL,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL,
    preco DECIMAL(20,2) NOT NULL,
    FOREIGN KEY (compra_id) REFERENCES Compra(id) ON DELETE CASCADE,
    FOREIGN KEY (produto_id) REFERENCES Produto(id) ON DELETE CASCADE
);

-- Tabela de Vendas
CREATE TABLE Venda (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data DATE NOT NULL,
    total DECIMAL(15,2) NOT NULL
);

-- Tabela de Itens da Venda
CREATE TABLE ItemVenda (
    id INT AUTO_INCREMENT PRIMARY KEY,
    venda_id INT NOT NULL,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL,
    preco DECIMAL(15,2) NOT NULL,
    FOREIGN KEY (venda_id) REFERENCES Venda(id) ON DELETE CASCADE,
    FOREIGN KEY (produto_id) REFERENCES Produto(id) ON DELETE CASCADE
);

-- Tabela de Movimentações de Estoque
CREATE TABLE Movimentacao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    tipo ENUM('Entrada', 'Saida') NOT NULL,
    quantidade INT NOT NULL,
    data DATETIME NOT NULL,
    FOREIGN KEY (produto_id) REFERENCES Produto(id) ON DELETE CASCADE
);
