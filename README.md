# ProjetoTasks

# Descrição do projeto
Este projeto,que se chama Tasks, tem como objetivo desenvolver uma aplicação de lista de tarefas voltada para pessoas com Transtorno de Déficit de Atenção e Hiperatividade (TDAH), priorizando simplicidade, clareza e facilidade de uso. A proposta busca não apenas atender às necessidades básicas de organização de tarefas, mas também oferecer uma experiência que reduza distrações e ajude o usuário a manter o foco em suas atividades diárias.
O objetivo é desenvolver uma aplicação web responsiva, voltada principalmente para dispositivos móveis, que permita ao usuário gerenciar suas tarefas de forma simples e eficiente. A aplicação deverá oferecer funcionalidades essenciais como adicionar novas tarefas, visualizar a lista de atividades, marcar tarefas como concluídas e removê-las quando necessário.

# Integrantes
GABRIEL DA SILVA FERREIRA<br>
JADIEL SOUSA SILVA COSTA<br>
JOÃO VICTOR SOUZA DOS ANJOS<br>
JONATHAN SILVA NASCIMENTO<br>
MONIQUE FERREIRA DOS SANTOS VELOSO.<br>

# Tecnologias utilizadas
O sistema foi desenvolvido utilizando uma arquitetura de desacoplamento entre o cliente (Front-end) e o servidor (Back-end), permitindo um carregamento mais rápido no dispositivo do usuário e facilitando a manutenção isolada do código.

-  Front-End (Interface do Usuário)

React.js (JavaScript): Biblioteca principal utilizada para construir uma interface de usuário baseada em componentes reutilizáveis. O React foi escolhido devido à sua eficiência na atualização da tela (através do Virtual DOM), permitindo que os cartões de tarefas e lembretes se atualizem instantaneamente sem a necessidade de recarregar a página inteira.<br>

React Hooks (useState, useEffect): Utilizados para o gerenciamento de estados internos da aplicação (como abrir/fechar modais, armazenar dados vindos da API e controlar menus flutuantes) e para lidar com ciclos de vida e requisições assíncronas assim que a tela é renderizada.

CSS3 & Design Responsivo: Toda a estilização foi feita focando na experiência mobile-first (priorizando o acesso pelo celular). A interface conta com transições suaves e elementos visuais limpos para evitar a sobrecarga cognitiva do usuário.

FontAwesome: Biblioteca de ícones vetoriais utilizada para a criação do menu de navegação inferior (ícones de início, categorias, cronômetro e configurações).<br>


-  Back-End (Servidor e Processamento)
  
PHP: Linguagem de programação utilizada no lado do servidor para a construção da API. O PHP atua recebendo as requisições do Front-end (via métodos GET e POST), realizando as regras de negócio (como criar, concluir ou excluir tarefas e lembretes) e respondendo no formato JSON.

Sessões Nativas do PHP (session_start): Mecanismo utilizado para o controle de autenticação do usuário. Garante que um usuário só consiga visualizar e alterar as suas próprias tarefas, validando se a sessão está ativa a cada requisição.

-  Banco de Dados e Infraestrutura
  
MySQL: Sistema de Gerenciamento de Banco de Dados Relacional (SGBDR) utilizado para persistir as informações do sistema. Ele armazena de forma estruturada os dados dos usuários, a listagem de tarefas com seus respectivos prazos e prioridades, e os lembretes rápidos.

Fetch API (JavaScript): Protocolo nativo utilizado pelo React para realizar a comunicação assíncrona com o servidor PHP através do envio e recebimento de dados com a propriedade credentials: 'include' para a validação segura de cookies de sessão.

# Funcionalidade do sistema<br>

• Login e Cadastro.<br>
• Recuperar senha.<br>
• Adicionar tarefas.<br>
• Listar tarefas.<br>
• Remover tarefas.<br>
• Marcar como concluída.<br>
• Destacar tipo de tarefas.<br>
• Sistema de Lembretes.<br>
• Pomodoro com música opcional.<br>
• Gamificação de fases.<br>

# Instrunções de execução(desatualizado)

Nesse projeto utilizaremos  o VScode,Xampp e Mysql

link para baixar o vscode:
https://code.visualstudio.com/download

link para baixar o xampp:
https://www.apachefriends.org/pt_br/download.html

link para baixar o mysql:
https://downloads.mysql.com/archives/workbench/

crie uma pasta no C:\xampp\htdocs<br>
crie os arquivos .php e css dentro da pasta.<br>
coloque os códigos disponiveis nesse repositório.<br>

abra o xampp e clique em Start nos módulos Apache e mysql.<br>

abra o mysql crie um banco de dados chamado "tarefas_app".<br>
coloque o script de banco de dados disponivel nesse repositório e execute.<br>

Para abrir o projeto,abra um navegador e digite http://localhost/(nomedapasta)/welcome.php

# Melhorias Futuras
Para as próximas etapas de desenvolvimento, pretendemos implementar recursos avan
çados que transformarão o aplicativo em uma ferramenta mais completa, inteligente
e segura:

• Gamificação e Recompensas por Fases: Expandir a lógica de progresso para liberar
recompensas visuais (novos temas e medalhas) e mensagens de incentivo sempre
que o usuário atingir as metas de tarefas concluídas, estimulando o engajamento de
pessoas com TDAH.

• Ativação da Tela de Categorias: Desenvolver o CRUD completo no React e PHP
para fazer a tela de categorias funcionar plenamente. Isso permitirá ao usuário
segmentar suas obrigações por contextos (como "Trabalho", "Estudos"e "Pessoal").

• Inteligência Artificial para Quebra de Tarefas: Integrar o sistema à API de IA (como
OpenAI ou Gemini) para que, com apenas um clique, tarefas longas ou complexas
sejam desmembradas automaticamente em uma lista de micro-tarefas mais fáceis de
gerenciar.

• Estratégias de Monetização: Estudar modelos de sustentabilidade financeira para o
projeto, como o modelo Freemium (recursos básicos gratuitos e funções premium,
como a IA, exclusivas para assinantes) ou a inserção de anúncios discretos.

• Segurança Avançada e Token JWT: Substituir o sistema tradicional de sessões por
autenticação via JWT (JSON Web Tokens), aplicar algoritmos robustos de cripto
grafia (Bcrypt) no banco de dados e migrar definitivamente para servidores com SSL
ponta a ponta, eliminando os alertas dos navegadores.
