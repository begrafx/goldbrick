<?php

namespace Drupal\goldbrick\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Goldbrick diagnostics report controller.
 */
class GoldbrickReportController extends ControllerBase {

  /**
   * Displays diagnostics report.
   */
  public function report() {

    $checks = [];

    // Check if Drupal JS is loaded.
    $checks[] = [
      'name' => 'Drupal JS Loaded',
      'status' => isset($_SERVER['HTTP_USER_AGENT']) ? 'Unknown (client-side check required)' : 'Unknown',
      'description' => 'Verify Drupal object exists in browser console.',
    ];

    // Check if toolbar module is enabled.
    $moduleHandler = \Drupal::service('module_handler');
    $checks[] = [
      'name' => 'Toolbar module enabled',
      'status' => $moduleHandler->moduleExists('toolbar') ? 'OK' : 'FAIL',
      'description' => 'Admin toolbar requires toolbar module.',
    ];

    // Check theme libraries
    $checks[] = [
      'name' => 'Theme libraries attached',
      'status' => 'Check browser Network tab',
      'description' => 'Ensure core/drupal is loaded.',
    ];

    return [
      '#type' => 'markup',
      '#markup' => $this->buildReport($checks),
    ];
  }

  /**
   * Builds HTML report.
   */
  private function buildReport(array $checks) {
    $output = '<h1>Goldbrick Diagnostics</h1><ul>';

    foreach ($checks as $check) {
      $output .= '<li><strong>' . $check['name'] . ':</strong> '
        . $check['status']
        . '<br><em>' . $check['description'] . '</em></li><br>';
    }

    $output .= '</ul>';

    return $output;
  }

}