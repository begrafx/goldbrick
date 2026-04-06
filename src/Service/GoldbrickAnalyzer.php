<?php

namespace Drupal\goldbrick\Service;

class GoldbrickAnalyzer {

  public function runChecks(): array {
    $checks = [];

    $checks[] = [
      'id' => 'user_auth',
      'label' => 'User authenticated',
      'status' => \Drupal::currentUser()->isAuthenticated() ? 'OK' : 'Anonymous',
    ];

    $checks[] = [
      'id' => 'theme',
      'label' => 'Active theme',
      'status' => \Drupal::theme()->getActiveTheme()->getName(),
    ];

    return $checks;
  }
}
