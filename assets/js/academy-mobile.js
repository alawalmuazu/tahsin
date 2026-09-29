(function () {
	function labelTables() {
		var tables = document.querySelectorAll('body.academy-phone .content-body table');
		for (var t = 0; t < tables.length; t++) {
			var heads = tables[t].querySelectorAll('thead th');
			if (!heads.length) continue;
			var labels = [];
			for (var h = 0; h < heads.length; h++) {
				labels.push((heads[h].textContent || '').replace(/\s+/g, ' ').trim());
			}
			var cells = tables[t].querySelectorAll('tbody td');
			for (var c = 0; c < cells.length; c++) {
				if (cells[c].getAttribute('data-label')) continue;
				var row = cells[c].parentNode;
				var index = 0;
				var sib = cells[c];
				while ((sib = sib.previousElementSibling)) index++;
				cells[c].setAttribute('data-label', labels[index] || '');
			}
		}
	}
	function start() {
		labelTables();
		var root = document.querySelector('body.academy-phone .content-body');
		if (!root || !window.MutationObserver) return;
		var pending = false;
		var observer = new MutationObserver(function () {
			if (pending) return;
			pending = true;
			setTimeout(function () {
				pending = false;
				labelTables();
			}, 40);
		});
		observer.observe(root, { childList: true, subtree: true });
	}
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', start);
	} else {
		start();
	}
})();
