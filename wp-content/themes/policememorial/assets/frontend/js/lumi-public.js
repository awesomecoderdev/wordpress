/**
 * The public of the Theme.
 *
 * @link              https://awesomecoder.dev/
 * @since             1.0.0
 * @package           lumi
 *
 *                                                              _
 *                                                             | |
 *    __ ___      _____  ___  ___  _ __ ___   ___  ___ ___   __| | ___ _ __
 *   / _` \ \ /\ / / _ \/ __|/ _ \| '_ ` _ \ / _ \/ __/ _ \ / _` |/ _ \ '__|
 *  | (_| |\ V  V /  __/\__ \ (_) | | | | | |  __/ (_| (_) | (_| |  __/ |
 *   \__,_| \_/\_/ \___||___/\___/|_| |_| |_|\___|\___\___/ \__,_|\___|_|
 *
 */

console.log("LumiAjaxUrl", LumiAjaxUrl);
console.log("LumiCartUrl", LumiCartUrl);

// check jquery is exist
if (typeof $ === "undefined") {
	let $ = jQuery;
}

// progress the operation
$(document).ready(function () {
	// start category dropdown
	$(document).on("click", "#sidebar-categories-dropdown", function (e) {
		e.preventDefault();
		$(".sidebar-categories").toggleClass("hidden");
		$(".sidebar-categories-arrow").toggleClass("rotate-180");
	});

	// start category dropdown
	$(document).on("click", "#sidebar-tags-dropdown", function (e) {
		e.preventDefault();
		$(".sidebar-tags").toggleClass("hidden");
		$(".sidebar-tags-arrow").toggleClass("rotate-180");
	});

	// add To Wishlist
	$(document).on("click", "#add-to-wishlist", function (e) {
		e.preventDefault();
		const product_id = $(this).attr("data-product");
		if (product_id) {
			$.ajax({
				type: "POST",
				url: `${LumiAjaxUrl}?action=lumi_wishlist`,
				data: {
					product_id,
				},
				success: function ({ success, data }) {
					if (success) {
						$(".product-wishlist-item").removeClass("text-red-500");
						$(".product-wishlist-item").attr("fill", "none");
						data?.wishlist?.map((product) => {
							console.log("product", product);
							$(`.product-wishlist-${product}`).addClass(
								"text-red-500"
							);
							$(`.product-wishlist-${product}`).attr(
								"fill",
								"currentColor"
							);
						});
					}
				},
			}); // End ajax
		}
	});

	// increment wishlist quantity
	$(document).on("click", "#wishlist-quantity-increment", function (e) {
		e.preventDefault();
		let quantity = parseInt(
			$(this).siblings("#wishlist-quantity").val() ?? 1
		);
		$(this).siblings("#wishlist-quantity").val(++quantity);
	});

	// decrement wishlist quantity
	$(document).on("click", "#wishlist-quantity-decrement", function (e) {
		e.preventDefault();
		let quantity = parseInt(
			$(this).siblings("#wishlist-quantity").val() ?? 1
		);

		if (quantity > 1) {
			$(this).siblings("#wishlist-quantity").val(--quantity);
		}
	});

	// add to cart from wishlist
	$(document).on("submit", ".add-to-cart-from-wishlist", function (e) {
		e.preventDefault();
		let add_to_bag = $(this).find("#add-to-bag");
		let add_to_cart_loading = $(this).find("#add-to-cart-loading");
		add_to_bag.addClass("hidden");
		add_to_cart_loading.removeClass("hidden");
		$.ajax({
			type: "POST",
			url: LumiCartUrl,
			data: $(this).serialize(),
			success: function (response) {
				if (response?.error) {
					// window.location = response?.product_url ?? lumi?.url ?? "/";
					try {
						$.toast({
							heading: lumi.toast.error.heading,
							text: lumi.toast.error.message,
							bgColor: "#e11d48",
							textColor: "white",
							position: "bottom-right",
							afterHidden: function () {
								window.location =
									response?.product_url ?? lumi?.url ?? "/";
							},
						});
					} catch (err) {
						// skip
					}
				} else {
					try {
						$.toast({
							heading: lumi.toast.success.heading,
							text: lumi.toast.success.message,
							bgColor: "#059669",
							textColor: "white",
							position: "bottom-right",
						});
					} catch (err) {
						// skip
					}

					if (response?.fragments?.lumi_cart_fragment) {
						$("#lumi-cart-fragment").html(
							response.fragments.lumi_cart_fragment
						);
					}

					if (response?.fragments?.lumi_cart_fragment) {
						$("#lumi-cart-mobile-fragment").html(
							response.fragments.lumi_cart_mobile_fragment
						);
					}
				}

				setTimeout(() => {
					add_to_bag.removeClass("hidden");
					add_to_cart_loading.addClass("hidden");
				}, 700);
			},
			error: function (error) {
				try {
					$.toast({
						heading: lumi.toast.error.heading,
						text: lumi.toast.error.message,
						bgColor: "#e11d48",
						textColor: "white",
						position: "bottom-right",
					});
				} catch (err) {
					// skip
				}
				setTimeout(() => {
					add_to_bag.removeClass("hidden");
					add_to_cart_loading.addClass("hidden");
				}, 700);
			},
		}); // End ajax
	});

	// add all to cart from wishlist
	$(document).on("click", "#add-all-bag", function (e) {
		e.preventDefault();
		let error = false;
		let add_to_bag = $(this).find("#add-to-bag-svg");
		let add_to_cart_loading = $(this).find("#add-all-cart-loading");
		let loading = true;

		add_to_bag.addClass("hidden");
		add_to_cart_loading.removeClass("hidden");

		let forms = $(".add-all-to-wishlist");
		let formsLength = forms?.length - 1 ?? null;
		$.each(forms, function (index, form) {
			$.ajax({
				type: "POST",
				url: LumiCartUrl,
				data: $(form).serialize(),
				success: function (response) {
					console.log("response", response);
					if (response?.error) {
						error = response.error;
					} else {
						if (response?.fragments?.lumi_cart_fragment) {
							$("#lumi-cart-fragment").html(
								response.fragments.lumi_cart_fragment
							);
						}
						if (response?.fragments?.lumi_cart_fragment) {
							$("#lumi-cart-mobile-fragment").html(
								response.fragments.lumi_cart_mobile_fragment
							);
						}
						try {
							$.toast({
								heading: lumi.toast.success.heading,
								text: lumi.toast.success.message,
								bgColor: "#059669",
								textColor: "white",
								position: "bottom-right",
							});
						} catch (err) {
							// skip
						}
					}
					if (index == formsLength) {
						add_to_bag.removeClass("hidden");
						add_to_cart_loading.addClass("hidden");
						// window.location = response?.product_url ?? lumi?.url ?? "/";
						try {
							if (error) {
								console.log("error", error);
								$.toast({
									heading: lumi.toast.error.heading,
									text: lumi.toast.error.message,
									bgColor: "#e11d48",
									textColor: "white",
									position: "bottom-right",
									afterHidden: function () {
										window.location =
											response?.product_url ??
											lumi?.url ??
											"/";
									},
								});
							}
						} catch (err) {
							// skip
						}
					}
				},
				error: function (err) {
					console.log("error", err);
					error = err;
					try {
						$.toast({
							heading: lumi.toast.error.heading,
							text: lumi.toast.error.message,
							bgColor: "#e11d48",
							textColor: "white",
							position: "bottom-right",
						});
					} catch (err) {
						// skip
					}
					if (index == formsLength) {
						add_to_bag.removeClass("hidden");
						add_to_cart_loading.addClass("hidden");

						try {
							if (error) {
								console.log("error", error);
								$.toast({
									heading: lumi.toast.error.heading,
									text: lumi.toast.error.message,
									bgColor: "#e11d48",
									textColor: "white",
									position: "bottom-right",
									afterHidden: function () {
										window.location =
											response?.product_url ??
											lumi?.url ??
											"/";
									},
								});
							}
						} catch (err) {
							// skip
						}
					}
				},
			}); // End ajax
		});
	});

	// add to cart
	$(document).on("submit", ".add-to-cart", function (e) {
		e.preventDefault();
		let add_to_bag = $(this).find("#add-to-bag");
		let add_to_cart_loading = $(this).find("#add-to-cart-loading");
		add_to_bag.addClass("hidden");
		add_to_cart_loading.removeClass("hidden");

		$.ajax({
			type: "POST",
			url: LumiCartUrl,
			data: $(this).serialize(),
			success: function (response) {
				if (response?.error) {
					try {
						$.toast({
							heading: lumi.toast.error.heading,
							text: lumi.toast.error.message,
							bgColor: "#e11d48",
							textColor: "white",
							position: "bottom-right",
							afterHidden: function () {
								window.location =
									response?.product_url ?? lumi?.url ?? "/";
							},
						});
					} catch (err) {
						// skip
					}
				} else {
					try {
						$.toast({
							heading: lumi.toast.success.heading,
							text: lumi.toast.success.message,
							bgColor: "#059669",
							textColor: "white",
							position: "bottom-right",
						});
					} catch (err) {
						// skip
					}

					if (response?.fragments?.lumi_cart_fragment) {
						$("#lumi-cart-fragment").html(
							response.fragments.lumi_cart_fragment
						);
					}

					if (response?.fragments?.lumi_cart_fragment) {
						$("#lumi-cart-mobile-fragment").html(
							response.fragments.lumi_cart_mobile_fragment
						);
					}
				}

				// console.log("response", response);
				// // $.toast("Here you can put the text of the toast");

				setTimeout(() => {
					add_to_bag.removeClass("hidden");
					add_to_cart_loading.addClass("hidden");
				}, 700);
			},
			error: function (error) {
				try {
					$.toast({
						heading: lumi.toast.error.heading,
						text: lumi.toast.error.message,
						bgColor: "#e11d48",
						textColor: "white",
						position: "bottom-right",
					});
				} catch (err) {
					// skip
				}
				setTimeout(() => {
					add_to_bag.removeClass("hidden");
					add_to_cart_loading.addClass("hidden");
				}, 700);
			},
		}); // End ajax
	});

	// remove from cart
	$(document).on("click", "#remove-from-wishlist", function (e) {
		e.preventDefault();
		let product_id = $(this).attr("data-product");

		$.ajax({
			type: "POST",
			url: `${LumiAjaxUrl}?action=lumi_remove_from_cart`,
			data: {
				product_id,
			},
			success: function (response) {
				$(`#cart-item-${product_id}`).fadeOut();

				if (response?.data?.empty) {
					$("#main").addClass("hidden");
					$("#empty-cart-page").removeClass("hidden");
				}

				if (response?.data?.sidebar) {
					$("#lumi-cart-sidebar").html(response.data.sidebar);
				}

				if (response?.data?.fragments?.lumi_cart_fragment) {
					$("#lumi-cart-fragment").html(
						response.data.fragments.lumi_cart_fragment
					);
				}

				if (response?.data?.fragments?.lumi_cart_fragment) {
					$("#lumi-cart-mobile-fragment").html(
						response.data.fragments.lumi_cart_mobile_fragment
					);
				}

				console.log("response", response);
			},
			error: function (error) {
				console.log("error", error);
				try {
					$.toast({
						heading: lumi.toast.error.heading,
						text: lumi.toast.error.message,
						bgColor: "#e11d48",
						textColor: "white",
						position: "bottom-right",
					});
				} catch (err) {
					// skip
				}
			},
		}); // End ajax
	});

	// increment cart quantity
	$(document).on("click", "#cart-quantity-increment", function (e) {
		e.preventDefault();
		let el = $(this).siblings(".quantity").find(".cart-quantity");

		let quantity = parseInt(el.val() ?? 1);
		let product_id = $(this).attr("data-product");
		el.val(++quantity);

		$.ajax({
			type: "POST",
			url: `${LumiAjaxUrl}?action=lumi_update_cart&type=increment`,
			data: {
				product_id,
				quantity,
			},
			success: function (response) {
				if (response?.data?.sidebar) {
					$("#lumi-cart-sidebar").html(response.data.sidebar);
				}

				if (response?.data?.fragments?.lumi_cart_fragment) {
					$("#lumi-cart-fragment").html(
						response.data.fragments.lumi_cart_fragment
					);
				}

				if (response?.data?.fragments?.lumi_cart_fragment) {
					$("#lumi-cart-mobile-fragment").html(
						response.data.fragments.lumi_cart_mobile_fragment
					);
				}

				console.log("response", response);
			},
			error: function (error) {
				try {
					$.toast({
						heading: lumi.toast.error.heading,
						text: lumi.toast.error.message,
						bgColor: "#f43f5e",
						textColor: "white",
						position: "bottom-right",
					});
				} catch (err) {
					// skip
				}
				console.log("error", error);
			},
		}); // End ajax
	});

	// decrement cart quantity
	$(document).on("click", "#cart-quantity-decrement", function (e) {
		e.preventDefault();
		let el = $(this).siblings(".quantity").find(".cart-quantity");

		let quantity = parseInt(el.val() ?? 1);
		let product_id = $(this).attr("data-product");

		if (quantity > 1) {
			el.val(--quantity);
		}

		$.ajax({
			type: "POST",
			url: `${LumiAjaxUrl}?action=lumi_update_cart&type=decrement`,
			data: {
				product_id,
				quantity,
			},
			success: function (response) {
				if (response?.data?.sidebar) {
					$("#lumi-cart-sidebar").html(response.data.sidebar);
				}

				if (response?.data?.fragments?.lumi_cart_fragment) {
					$("#lumi-cart-fragment").html(
						response.data.fragments.lumi_cart_fragment
					);
				}

				if (response?.data?.fragments?.lumi_cart_fragment) {
					$("#lumi-cart-mobile-fragment").html(
						response.data.fragments.lumi_cart_mobile_fragment
					);
				}

				console.log("response", response);
			},
			error: function (error) {
				try {
					$.toast({
						heading: lumi.toast.error.heading,
						text: lumi.toast.error.message,
						bgColor: "#e11d48",
						textColor: "white",
						position: "bottom-right",
					});
				} catch (err) {
					// skip
				}
				console.log("error", error);
			},
		}); // End ajax
	});

	// increment product quantity
	$(document).on("click", "#product-quantity-increment", function (e) {
		e.preventDefault();
		let el = $(this).siblings("#product-quantity");

		let quantity = parseInt(el.val() ?? 1);
		el.val(++quantity);
	});

	// decrement product quantity
	$(document).on("click", "#product-quantity-decrement", function (e) {
		e.preventDefault();
		let el = $(this).siblings("#product-quantity");

		let quantity = parseInt(el.val() ?? 1);

		if (quantity > 1) {
			el.val(--quantity);
		}
	});

	// password show hidden
	$(document).on("click", ".password-integrator", function (e) {
		e.preventDefault();
		let type = $("#password").attr("type");

		if (type == "password") {
			$("#password").attr("type", "text");
			$("#password-hidden").addClass("hidden");
			$("#password-show").removeClass("hidden");
		} else {
			$("#password").attr("type", "password");
			$("#password-hidden").removeClass("hidden");
			$("#password-show").addClass("hidden");
		}
	});

	// confirmed password show hidden
	$(document).on("click", ".confirmed-password-integrator", function (e) {
		e.preventDefault();
		let type = $("#confirm_password").attr("type");

		if (type == "password") {
			$("#confirm_password").attr("type", "text");
			$("#confirmed-password-hidden").addClass("hidden");
			$("#confirmed-password-show").removeClass("hidden");
		} else {
			$("#confirm_password").attr("type", "password");
			$("#confirmed-password-hidden").removeClass("hidden");
			$("#confirmed-password-show").addClass("hidden");
		}
	});

	// customer login
	$("#login-form").validate({
		rules: {
			email: {
				required: true,
				email: true,
			},
			password: {
				required: true,
				minlength: 5,
			},
		},
		messages: {
			password: {
				required: "Please provide a password",
				minlength: "Password must be at least 8 characters",
			},
			email: "Please enter a valid email address",
		},
		// errorPlacement: function (error, element) {
		// 	console.log("error", error[0]);
		// 	let message = error[0] ? error[0]?.innerText : false;
		// 	console.log("message", message);
		// 	if (message) {
		// 		$.toast({
		// 			heading: lumi.toast.error.heading,
		// 			text: `${message}`,
		// 			bgColor: "#e11d48",
		// 			textColor: "white",
		// 			position: "bottom-right",
		// 		});
		// 	}
		// },
		submitHandler: function (form) {
			form = $(form).serialize();
			$.ajax({
				type: "POST",
				url: `${LumiAjaxUrl}?action=lumi_login`,
				data: form,
				success: function (response) {
					if (response.success) {
						try {
							$.toast({
								heading: lumi.toast.success.heading,
								text: response.message,
								bgColor: "#059669",
								textColor: "white",
								position: "bottom-right",
								afterHidden: function () {
									location.reload();
								},
							});
						} catch (error) {
							location.reload();
						}
					} else {
						if (response?.errors) {
							response?.errors?.map((error) => {
								try {
									$.toast({
										heading: lumi.toast.error.heading,
										text: error,
										bgColor: "#e11d48",
										textColor: "white",
										position: "bottom-right",
									});
								} catch (error) {
									// skip
								}
							});
						}
					}
				}, // Success
				error: function (error) {
					console.log("error", error);
					try {
						$.toast({
							heading: lumi.toast.error.heading,
							text: lumi.toast.error.message,
							bgColor: "#e11d48",
							textColor: "white",
							position: "bottom-right",
						});
					} catch (err) {
						// skip
					}
				}, // Error
			}); // End ajax
		},
	});

	// single product trigger
	$(document).on("click", ".single-product-image-trigger", function (e) {
		e.preventDefault();
		$(".single-product-image-trigger").removeClass("active");
		$(this).addClass("active");

		let current = $(this).attr("data-id");
		$(".single-product-image").hide();
		$(current).show();
	});

	// select color
	$(document).on("click", "#product-colors-item", function (e) {
		e.preventDefault();
		$(".product-colors-item").removeClass("active");
		$(this).addClass("active");
		let color = $(this).attr("data-color");
		$("#lumi-color").val(color);
	});

	// select size
	$(document).on("click", "#product-sizes-item", function (e) {
		e.preventDefault();
		$(".product-sizes-item").removeClass("active");
		$(this).addClass("active");
		let size = $(this).attr("data-size");
		$("#lumi-size").val(size);
	});
});

$(document).ready(function () {
	$(document).on("submit", "#", function (e) {
		e.preventDefault();
		$(".message").last().after("hello");
	});
});
