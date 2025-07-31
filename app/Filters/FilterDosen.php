<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class FilterDosen implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('user_id')) {
            return redirect()->to(base_url('Auth/Login'));
        }
        
        // Allow access for level 5 (Dosen) and admin levels (1, 2)
        if (in_array(session()->get('level'), [1, 2, 5])) {
            return;
        }
        
        // Redirect non-dosen users to home
        return redirect()->to(base_url());
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing in after filter
    }
}