<?php

namespace Modules\Shared\Core\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\View\View;
use Config\View as ConfigView;

class BaseWebController extends BaseController
{
    private $renderer;

    protected $viewPath;

    public function __construct()
    {
        /**
         * @var CodeIgniter\View\View $renderer
         */
        $this->renderer = new View(new ConfigView(), ROOTPATH);
    }

    protected function renderView(string $name, array $data = [], array $options = [])
    {
        $saveData = config(View::class)->saveData;

        if (array_key_exists('saveData', $options)) {
            $saveData = (bool) $options['saveData'];
            unset($options['saveData']);
        }

        $modulepath = strstr($this->viewPath, 'modules');
        $modulepath = str_replace('controllers', 'views', $modulepath);

        $data['renderer'] = $this->renderer;

        return $this->renderer
            ->setData($data, 'raw')
            ->render($modulepath.'/'.$name, $options, $saveData);
    }
}
