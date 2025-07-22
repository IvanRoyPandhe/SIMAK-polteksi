<?php

namespace App\Validation;

class DomainEmail
{
  public function check_domain(string $email): bool
  {
    list(, $domain) = explode('@', $email);
    $allowed_domains = ['gmail.com', 'yahoo.com', 'outlook.com'];
    return in_array($domain, $allowed_domains);
  }
}
