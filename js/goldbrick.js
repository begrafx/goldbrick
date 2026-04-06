(function () {

  function detectIssues() {
    const issues = [];

    if (typeof window.Drupal === 'undefined') {
      issues.push({ id: 'drupal_missing', severity: 'critical', message: 'Drupal JS not initialized' });
      return issues;
    }

    if (!Drupal.behaviors) {
      issues.push({ id: 'behaviors_missing', severity: 'critical', message: 'Drupal.behaviors missing' });
    }

    if (!Drupal.ajax) {
      issues.push({ id: 'ajax_missing', severity: 'warning', message: 'Drupal AJAX system missing' });
    }

    return issues;
  }

  function expose(issues) {
    window.goldbrick = {
      status: issues.some(i => i.severity === 'critical') ? 'critical' : issues.length ? 'warning' : 'ok',
      issues: issues,
      timestamp: Date.now()
    };
  }

  function renderOverlay(issues) {
    if (!issues.length) return;

    const el = document.createElement('div');
    el.style = 'position:fixed;bottom:0;left:0;right:0;background:#7f1d1d;color:#fff;padding:10px;z-index:9999;font-size:13px;';
    el.innerHTML = '<strong>Goldbrick Issues:</strong><br>' +
      issues.map(i => '• ' + i.message).join('<br>');

    document.body.appendChild(el);
  }

  function run() {
    const issues = detectIssues();
    expose(issues);
    renderOverlay(issues);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', run);
  } else {
    run();
  }

})();