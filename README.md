# 🚗 Servix Auto - Agendamento de Oficina

![Status do Projeto](https://img.shields.io/badge/status-concluído-green)

O Servix Auto é um sistema web para gerenciamento de serviços em uma oficina mecânica. Ele permite o cadastro de clientes, profissionais, serviços e, principalmente, o agendamento e consulta desses serviços.

Este projeto foi desenvolvido como um trabalho acadêmico.

## ✨ Funcionalidades Principais

* **Gestão de Clientes:** CRUD (Criar, Ler, Atualizar, Deletar) de clientes.
* **Gestão de Profissionais:** CRUD de mecânicos e outros funcionários.
* **Gestão de Serviços:** CRUD dos serviços oferecidos pela oficina.
* **Sistema de Agendamento:** Permite marcar, consultar e editar os agendamentos, vinculando clientes, profissionais e serviços.
* **Relatórios:** Geração de relatórios (ex: serviços agendados).

## 🛠️ Tecnologias Utilizadas

* **PHP:** Linguagem principal (backend).
* **MySQL:** Banco de dados para armazenamento dos dados.
* **HTML5 e CSS3:** Estruturação e estilização das páginas.
* **SQL:** Linguagem de consulta para o banco de dados.

## 🚀 Como Executar o Projeto

Para rodar este projeto localmente, siga os passos abaixo:

1.  **Pré-requisitos:**
    * Ter um servidor web local instalado (Ex: XAMPP, WAMP, MAMP).
    * Ter um SGBD MySQL (normalmente incluído no XAMPP).

2.  **Clone o Repositório:**
    ```bash
    git clone [URL_DO_SEU_REPOSITORIO_AQUI]
    ```
    *Ou apenas baixe os arquivos ZIP.*

3.  **Mova os Arquivos:**
    * Mova a pasta do projeto para o diretório `htdocs` (do XAMPP) ou `www` (do WAMP/MAMP).

4.  **Banco de Dados:**
    * Acesse seu `phpMyAdmin` (ou SGBD de preferência).
    * Crie um novo banco de dados (ex: `projetophp`, como vimos no seu arquivo).
    * Localize o arquivo `.sql` na pasta `Banco de Dados/` do projeto e importe-o para o banco que você acabou de criar.

5.  **Configure a Conexão:**
    * **IMPORTANTE:** O arquivo `conexao.php` **não deve** ser enviado para o repositório se contiver senhas.
    * Certifique-se de que o arquivo `conexao.php` na sua máquina local tenha o usuário e senha corretos para o seu banco de dados.
    * *Exemplo (como o seu):*
        ```php
        $dominio = 'mysql:host=localhost;dbname=projetophp';
        $usuario = 'root';
        $senha = '';
        ```

6.  **Acesse:**
    * Inicie seu servidor Apache e MySQL.
    * Abra o navegador e acesse: `http://localhost/[NOME_DA_PASTA_DO_PROJETO]/`

## 👨‍💻 Autor

* **[Seu Nome Completo Aqui]**
    * [Seu Email]
    * [Seu LinkedIn ou GitHub (Opcional)]
