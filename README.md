# 📇 API de Contatos

Uma API simples que simula o funcionamento de uma lista de contatos, desenvolvida para prática de **Back-End**, **PHP**, **PDO** e **API REST**.

---

## 💻 Tecnologias Utilizadas

### 🖥️ Back-end
- **🐘 PHP:** PDO, APIs REST
- **🐬 MySQL:** Modelagem, queries, integração com PHP  
- **📐 Design Patterns:** Active Record, Table Data Gateway  

### 🌐 Ferramentas e Ambiente
- **⚡ XAMPP:** Apache e MySQL  
- **🛠️ Postman:** Testes de API  

---

## 🚀 Instalação
1. Copie a pasta do projeto para o diretório `htdocs` do XAMPP.  
2. Inicie o **Apache** e o **MySQL** pelo XAMPP.  
3. Acesse a API via navegador ou ferramenta de requisições HTTP em [http://localhost/contacts-api/](http://localhost/contacts-api/)

## 🛠️ Endpoints da API

### 1️⃣ Criar um Contato
**POST /contacts**  

**Parâmetros (JSON):**
```json
{
"name": "Nome do Contato",
"email": "email@exemplo.com",
"phoneNumber": "123456789"
}
```
### 2️⃣ Listar Todos os Contatos

GET /contacts

3️⃣ Obter Contato por ID

GET /contacts?id={id}

4️⃣ Atualizar Contato

PUT /contacts?{id}

**Parâmetros (JSON):**
```json
{
"name": "Novo Nome",
"email": "novoemail@exemplo.com",
"phone": "987654321"
}
```
5️⃣ Remover Contato

DELETE /contacts?id={id}
