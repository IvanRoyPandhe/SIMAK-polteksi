<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Config\Services;

abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = ['form'];

    /**
     * Property untuk menyimpan data user
     */
    protected $user;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $session = Services::session();
        $user_id = $session->get('user_id');
        if ($user_id) {
            $this->user = model('App\Models\ModelAdmin')->getUserById($user_id);
            
            // Set mahasiswa_id dan dosen_id ke session jika belum ada
            if ($this->user && !$session->get('mahasiswa_id') && isset($this->user['mahasiswa_id'])) {
                $session->set('mahasiswa_id', $this->user['mahasiswa_id']);
            }
            if ($this->user && !$session->get('dosen_id') && isset($this->user['dosen_id'])) {
                $session->set('dosen_id', $this->user['dosen_id']);
            }
        }
    }
}
