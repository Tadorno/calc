<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Título</h1>
    <br>
</p>

# Arquitetura
A arquitetura do projeto foi modelada a partir da estrutura básica do Yii framework, sendo incluído e repensado algumas de suas camadas nativas. As modificações realizadas estão destacadas com * na estrutura abaixo. 

-------------------

      assets/                           contains assets definition
      commands/                         contains console commands (controllers)
      components/                       contém os componentes criados para a aplicação
      config/                           contains application configurations
      controllers/                      contains Web controller classes
      controllers/ControllerTrait.php   Classe pai de todos os Controllers da aplicação*
      mail/                             contains view files for e-mails
      models/                           Na pasta raiz existirão apenas classes terminadas em Record(se extenderem ActoveRecord) ou
                                        Model(se extenderem Model)*
      models/enums/                     contém os enums do projeto*                                  
      models/forms/                     contem as entidades que representam forms (Ainda em análise sobre este item)*
      models/search/                    contem a regra de negócio para as telas de consulta*
      models/service/                   contem toda a regra de necócio da aplicação*
      models/service/ServiceTrait.php   Classe pai de todos os Services da aplicação*
      runtime/                          contains files generated during runtime
      tests/                            contains various tests for the basic application
      util/                             contem classes de utilidade para o projeto
      vendor/                           contains dependent 3rd-party packages
      views/                            contains view files for the Web application
      web/                              contains the entry script and Web resources
      
-------------------

 
# controllers/ControllerTrait
Originalmente os controller’s do Yii framework herdam de yii/web/Controller, nesta arquitetura os controller’s devem herdar de app/controller/ControllerTrait. Todos os métodos genéricos para os controladores serão implementados nesta classe, desta forma todos os controladores filhos irão herdar o comportamento genérico do pai.

# model/service/ServiceTrait
Originalmente no Yii framework, as regras de negócio são inseridas diretamente no model e nos exemplos do framework na classe controladora. Nesta arquitetura foi definido uma nova camada chamada de service, a qual será responsável entre manipular os dados e/ou executar regras. Todos os services irão extender ServiceTrait, desta forma irão herdar os comportamentos genéricos no pai.

# componentes/CustomActionColumn
Classe customizada do ActionColumn para gerar url com id criptografados

# util/MessageResponse
Utilitário responsável por armazenar o response que será enviado ao Controller a partir do Service

# util/EncrypterUtil
Utilitário responsável por criptografar/descriptografar dados na aplicação

# util/DateUtil
Utilitário responsável por manipulação de datas

# Subdivisões do model
Originalmente o Yii trata a pasta app/models para armazenar tudo referente ao model (entidade, dao, form, search e etc). Por questão de organização foi criado os seguintes sub-diretórios: 

-------------------

    /enums       Armazena os enums da aplicação; 
    
    /forms       Armazena as classes que refletem os formulários, caso existam (Em avaliação); 

    /services    Armazena os services da aplicação; 

    /search      Armazena os search’s utilizados para as telas de listagem; 

    /            Armazena os ActionRecords e Models. 
    
-------------------
