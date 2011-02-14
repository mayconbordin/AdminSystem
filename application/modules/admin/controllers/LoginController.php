<?php

class Admin_LoginController extends Zend_Controller_Action
{
	protected $_params;
	
    public function init()
    {
        // update the user's activity
        //$this->_helper->Authentication->updateUserActivity();
    }

    public function indexAction()
    {
        $this->view->errorMessage = null;
    	
    	// Cria uma instancia de Zend_Auth
        $objAuth = Zend_Auth::getInstance();
    
        // Verifica se já está autenticado
        if ( !$objAuth->hasIdentity() ) {
	    	// Instancia o formulário de login
	        //$objFormLogin = new Login_Form_Login();
	        //$this->view->objFormLogin = $objFormLogin;
	        
        	$objFormLogin = new Admin_Form_User();
        	$objFormLogin = $objFormLogin->getLoginForm();
        	$this->view->objFormLogin = $objFormLogin;
	 
	        // Verifica se foi submetido via POST
	        if( !$this->_request->isPost() ) {
	        	$this->_helper->Authentication->createChallenge($this->view);
	        	return false;
	        }
	
	        // Obtém os dados passados via POST
	        $this->_params = $this->_request->getPost();
	 
	        // Se os dados não forem validos
	        if(!$objFormLogin->isValid($this->_params)) {
	        	return false;
	        }
	 
	        //Pega o adaptador do BD
	        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
	 
	        /**
	         * Instancia o Auth Db Table Adapter
	         *
	         * Quando se instancia este objeto, precisamos informar as configurações
	         * do BD, nome da tabela onde os dados de login estão, o campo do nome
	         * do usuário, e o campo da senha na tabela.
	         */
	        $authAdapter = new Zend_Auth_Adapter_DbTable(
	                $dbAdapter,
	                'users',
	                'user_name',
	                'user_challenge'
	        );
	        			
	        /**
	         * Salva a chave de autenticação
	         */
	        //$userMapper = new Login_Model_UserMapper();
	        
	        $userRepository = new Admin_Model_User_Repository();
	        
	        //Pega o usuário que será autenticado
	        //$user = $userMapper->getByName( $this->_params['username'] );
	        $user = $userRepository->fetchByName( $this->_params['name'] );
	        
	        if ( $user != null ) {
		        $authNamespace = new Zend_Session_Namespace('Zend_Auth');
		        $challenge = $authNamespace->challenge;
		        
		        // registra o código do usuário na sessão
		        $authNamespace->userId = $user->getId();
		                
		        //Cria a chave de autenticação
		        //$key = sha1($challenge . $user->getPassword());
		        $key = hash('sha256', $challenge . $user->getPassword());
		        
		        //Atualiza a chave do objeto
		        $user->setChallenge( $key );
		        
		        //Atualiza a chave de autenticação do usuário
		        //$userMapper->updateChallenge( $user );
		        $userRepository->updateChallenge($user);
		        
		        // Configura as credencias user_email e user_password informadas pelo usuário
		        $authAdapter->setIdentity( $this->_params['name'] )
		        			->setCredential( $this->_params['challenge'] );
		 
		        // Tenta autenticar o usuário
		        $result = $objAuth->authenticate($authAdapter);
		 
		        /**
		         * Se o usuário for autenticado redireciona para a index e grava seu email,
		         * caso contrário exibe uma mensagem de alerta na página
		         */
		        if ( $result->isValid() ) {
		            /**
		             * Pega os dados do usuário, omitindo a senha
		             * http://framework.zend.com/manual/en/zend.auth.adapter.dbtable.html
		             */
		            $authData = $authAdapter->getResultRowObject( null, 'user_challenge' );
		 
		            // Armazena os dados do usuário
		            $objAuth->getStorage()->write( $authData );
		            
		            // faz a verificação de tentativas de login
		            //$this->_checkLoginAttempts(true);
		            $this->_helper->Authentication->checkLoginAttempts(true, $this->_params['name']);
		            
		            //COOKIE
		            $value = 'something from somewhere';
					setcookie("TestCookie", $value);

		            $this->_redirect("admin");
		        } else {
		        	// atribui a mensagem de erro
		        	$this->view->errorMessage = "Usuário e/ou senha inválidos";
		        	
		        	// faz a verificação de tentativas de login
		        	$this->_helper->Authentication->checkLoginAttempts(true, $this->_params['name']);
		        	
		        	// limpa a identidade de autenticação
		        	$objAuth->clearIdentity();
		        	
		        	// cria nova challenge
		        	$this->_helper->Authentication->createChallenge( $this->view );
		        }
	        } else {
	        	// atribui a mensagem de erro
	        	$this->view->errorMessage = "Usuário e/ou senha inválidos";
	        	
	        	// faz a verificação de tentativas de login
	        	$this->_helper->Authentication->checkLoginAttempts(true, $this->_params['name']);
	        	
	        	// limpa a identidade de autenticação
	        	$objAuth->clearIdentity();
	        	
	        	// cria nova challenge
	        	$this->_helper->Authentication->createChallenge( $this->view );
	        }
        } else {
        	$this->_redirect("admin");
        }
    }


}

