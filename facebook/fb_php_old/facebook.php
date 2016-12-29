class Facebook
{
    private $helper;

    public function __construct()
    {
        FacebookSession::setDefaultApplication('SuaAppId', 'SuaAppSecret');         
        $this->helper = new FacebookRedirectLoginHelper('http://seudominio.com/facebook-confirmado.php');
    }

    public function Login()
    {           
        $loginUrl = $this->helper->getLoginUrl(array('scope' => 'email'));
        header("Location: {$loginUrl}");
        exit;
    }

    public function GetSession()
    {
        try {
            $session = $this->helper->getSessionFromRedirect();
        }
        catch(FacebookRequestException $ex) {
            // Trate erros do FB aqui
        }
        catch(\Exception $ex) {
            // Trate outros erros aqui
        }

        if($session)
        {
            // Logado, obtém informações do usuário
            $user_profile = (new FacebookRequest(
                $session, 'GET', '/me'
            ))->execute()->getGraphObject(GraphUser::className());

            return $user_profile;
        }
    }
}