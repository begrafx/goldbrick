(function (Drupal) {
  function reportState() {
    const state = {
      drupalExists: typeof window.Drupal !== "undefined",
      behaviors: window.Drupal && window.Drupal.behaviors ? Object.keys(window.Drupal.behaviors) : [],
      jquery: typeof window.jQuery !== "undefined"
    };

    // Send back to Drupal
    fetch(Drupal.url("goldbrick/report/js"), {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify(state)
    });
  }

  Drupal.behaviors.goldbrickProbe = {
    attach: function () {
      reportState();
    }
  };
})(window.Drupal);