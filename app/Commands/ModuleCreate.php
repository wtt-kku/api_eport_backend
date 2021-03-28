<?php namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

/**
 * Create an Module in HMVC
 *
 * @package App\Commands
 * @author Mufid Jamaluddin <https://github.com/MufidJamaluddin/Codeigniter4-HMVC>
 */
class ModuleCreate extends BaseCommand
{
    /**
     * The group the command is lumped under
     * when listing commands.
     *
     * @var string
     */
    protected $group       = 'Development';

    /**
     * The Command's name
     *
     * @var string
     */
    protected $name        = 'module:create';

    /**
     * the Command's short description
     *
     * @var string
     */
    protected $description = 'Create CodeIgniter HMVC Modules in app/Modules folder';

    /**
     * the Command's usage
     *
     * @var string
     */
    protected $usage        = 'module:create [ModuleName] [Options]';

    /**
     * the Command's Arguments
     *
     * @var array
     */
    protected $arguments    = [ 'ModuleName' => 'Module name to be created' ];

    /**
     * the Command's Options
     *
     * @var array
     */
    protected $options      = [
        '-f' => 'Set module folder inside app path (default Modules)',
        '-v' => 'Set view folder inside app path (default Views/modules/)',
    ];

    /**
     * Module Name to be Created
     */
    protected $module_name;


    /**
     * Module folder (default /Modules)
     */
    protected $module_folder;


    /**
     * View folder (default /View)
     */
    protected $view_folder;


    /**
     * Run route:update CLI
     */
    public function run(array $params)
    {
        helper('inflector');

        $this->module_name = $params[0];

        if(!isset($this->module_name))
        {
            CLI::error("Module name must be set!");
            return;
        }

        $this->module_name = ucfirst($this->module_name);

        $module_folder         = $params['-f'] ?? CLI::getOption('f');
        $this->module_folder   = ucfirst($module_folder ?? 'Modules');

        $view_folder         = $params['-v'] ?? CLI::getOption('v');
        $this->view_folder   = $view_folder ?? 'Views';

        mkdir(APPPATH .  $this->module_folder . '/' . $this->module_name);

        try
        {
            $this->createConfig();
            $this->createController();
			$this->createRepository();
            $this->createModel();
			$this->createEntity();
            $this->createView();

            CLI::write('Module created!');
        }
        catch (\Exception $e)
        {
            CLI::error($e);
        }
    }

    /**
     * Create Config File
     */
    protected function createConfig()
    {
        $configPath = APPPATH .  $this->module_folder . '/' . $this->module_name . '/Config';

        mkdir($configPath);

        if (!file_exists($configPath . '/Routes.php'))
        {
            $routeName = strtolower($this->module_name);

            $template = "<?php

if(!isset(\$routes))
{ 
    \$routes = \Config\Services::routes(true);
}

\$routes->group('$routeName', ['namespace' => 'App\Modules\\$this->module_name\\Controllers'], function(\$subroutes){

	\$subroutes->add('', '".$this->module_name."::index');
	\$subroutes->add('dashboard', '".$this->module_name."::index');

});";

            file_put_contents($configPath . '/Routes.php', $template);
        }
        else
        {
            CLI::error("Can't Create Routes Config! Old File Exists!");
        }
    }

    /**
     * Create Controller File
     */
    protected function createController()
    {
        $controllerPath = APPPATH .  $this->module_folder . '/' . $this->module_name . '/Controllers';
		$controllerFileName = $this->module_name.'.php';

        mkdir($controllerPath);
		
		if (!file_exists($controllerPath . '/BaseController.php'))
        {
			$template = "<?php namespace App\Modules\\$this->module_name\\Controllers;

use CodeIgniter\Controller;

class BaseController extends Controller
{
    protected \$helpers = [];

    public function initController(\CodeIgniter\HTTP\RequestInterface \$request, \CodeIgniter\HTTP\ResponseInterface \$response, \Psr\Log\LoggerInterface \$logger)
    {
        // Do Not Edit This Line
        parent::initController(\$request, \$response, \$logger);
    }
}
";
			    file_put_contents($controllerPath . '/BaseController.php', $template);
        }
        else
        {
            CLI::error("Can't Create Base Controller! Old File Exists!");
        }

        if (!file_exists($controllerPath . '/' . $controllerFileName))
        {
            $template = "<?php namespace App\Modules\\$this->module_name\\Controllers;

use App\Modules\\$this->module_name\\Repositories\\".$this->module_name."Repositories;

class ".$this->module_name." extends BaseController
{
	private $" . strtolower($this->module_name) . "Repositories;

    /**
     * Constructor.
     */
    public function __construct()
    {
        \$this->" . strtolower($this->module_name) . "Repositories = new ".$this->module_name."Repositories();
    }

    public function index()
	{
		return \$this->" . strtolower($this->module_name) . "Repositories->examplePage();
	}

}
";
            file_put_contents($controllerPath . '/' . $controllerFileName, $template);
        }
        else
        {
            CLI::error("Can't Create Controller! Old File Exists!");
        }
    }
	
	/**
     * Create Repository File
     */
    protected function createRepository()
    {
        $repositoryPath = APPPATH .  $this->module_folder . '/' . $this->module_name . '/Repositories';
		$repositoryFileName = $this->module_name.'Repositories.php';

        mkdir($repositoryPath);

        if (!file_exists($repositoryPath . '/' . $repositoryFileName))
        {
            $template = "<?php namespace App\Modules\\$this->module_name\\Repositories;

use App\Modules\\$this->module_name\\Models\\".$this->module_name."Model;
use CodeIgniter\Controller;

class ".$this->module_name."Repositories extends Controller
{
    private \$" . strtolower($this->module_name) . "Model;

    /**
     * Constructor.
     */
    public function __construct()
    {
        \$this->" . strtolower($this->module_name) . "Model = new ".$this->module_name."Model();
    }

    public function examplePage()
	{
		\$data = [
		    'title' => 'Example Page (".$this->module_name.")',
            'view' => '" . strtolower($this->module_name) . "/example-page',
            'data' => \$this->" . strtolower($this->module_name) . "Model->get".$this->module_name."List(),
        ];

		return view('template/layout', \$data);
	}

}
";
            file_put_contents($repositoryPath . '/' . $repositoryFileName, $template);
        }
        else
        {
            CLI::error("Can't Create Repository! Old File Exists!");
        }
    }

    /**
     * Create Models File
     */
    protected function createModel()
    {
        $modelPath = APPPATH .  $this->module_folder . '/' . $this->module_name . '/Models';
		$modelFileName = $this->module_name.'Model.php';

        mkdir($modelPath);

        if (!file_exists($modelPath . '/' . $modelFileName))
        {

            $template = "<?php namespace App\Modules\\$this->module_name\\Models;
			
use App\Entities\\".$this->module_name."Entity;

class ".$this->module_name."Model
{
	public function __construct()
    {
        \$this->" . strtolower($this->module_name) . "Entity = new ".$this->module_name."Entity();        
        \$this->db = \Config\Database::connect();
    }
	
    public function get".$this->module_name."List()
    {
        // \$result = \$this->" . strtolower($this->module_name) . "Entity->findAll();
		\$result = [];
        return \$result;
    }
	
	public function get".$this->module_name."ById(\$id)
    {
       // $" . strtolower($this->module_name) . "Table = \$this->db->table('" . strtolower($this->module_name) . "');
       // \$result = \$" . strtolower($this->module_name) . "Table->select('*')
       // ->where('" . strtolower($this->module_name) . "_id', \$id)
       // ->get()->getResultArray();
		\$result = [];
		return \$result;
    }
}
	
	";
            file_put_contents($modelPath . '/' . $modelFileName, $template);
        }
        else
        {
            CLI::error("Can't Create ".$this->module_name."Model! Old File Exists!");
        }
    }
	
	/**
     * Create Entities File
     */
    protected function createEntity()
    {
        $entityPath = APPPATH .  '/Entities';

        if (!file_exists($entityPath . '/'.$this->module_name.'Entity.php')) {
            $template = "<?php namespace App\Entities;

use CodeIgniter\Model;

class ".$this->module_name."Entity extends Model
{
    protected \$table = '" . strtolower($this->module_name) . "';
    protected \$primaryKey = '" . strtolower($this->module_name) . "_id';
    protected \$returnType = 'array';
    protected \$allowedFields = [
        '" . strtolower($this->module_name) . "_id',
    ];
}";

            file_put_contents($entityPath . '/'.$this->module_name.'Entity.php', $template);
        }
        else
        {
            CLI::error("Can't Create ".$this->module_name."Entity! Old File Exists!");
        }

    }

    /**
     * Create View
     */
    protected function createView()
    {
        if($this->view_folder !== $this->module_folder)
            $view_path = APPPATH . $this->view_folder . '/' . strtolower($this->module_name);
        else
            $view_path = APPPATH . $this->module_folder . '/' . $this->module_name . '/Views';

        mkdir($view_path);

        if (!file_exists($view_path . '/example-page.php'))
        {
            $template = '<section>

	<h1>Example Page ('.$this->module_name.')</h1>

   	<p>If you would like to edit this page you will find it located at:</p>

	<pre><code>app/Views/'. strtolower($this->module_name) .'/example-page.php</code></pre>

	<p>The corresponding controller for this page can be found at:</p>

	<pre><code>app/Modules/'. $this->module_name .'/Controllers/'. $this->module_name .'.php</code></pre>

</section>';

            file_put_contents($view_path . '/example-page.php', $template);
        }
        else
        {
            CLI::error("Can't Create View! Old File Exists!");
        }

    }

}