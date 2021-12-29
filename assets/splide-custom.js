
		document.addEventListener('DOMContentLoaded', function () {
			var splide = new Splide('.splide', {
				perPage: 3,
				gap: 40,
				pagination: false,
				breakpoints: {
					1000: {
						perPage: 3,
						gap: 50,
						arrows: false,
						pagination: true,
					}
				},
				breakpoints: {
					768: {
						perPage: 1,
						gap: 0,
						arrows: false,
						pagination: true,

					}
				},


			});
			splide.mount();
		});
