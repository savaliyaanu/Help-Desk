"use strict";

// Class definition
var KTWizard1 = function () {
	// Base elements
	var _wizardEl;
	var _formEl;
	var _wizard;
	var _validations = [];

	// Private functions
	var initWizard = function () {
		// Initialize form wizard
		_wizard = new KTWizard(_wizardEl, {
			startStep: 1, // initial active step number
			clickableSteps: true  // allow step clicking
		});

		// Validation before going to next page
		_wizard.on('beforeNext', function (wizard) {
			// Don't go to the next step yet
			_wizard.stop();

			// Validate form
			var validator = _validations[wizard.getStep() - 1]; // get validator for currnt step
			validator.validate().then(function (status) {
				if (status == 'Valid') {
					_wizard.goNext();
					KTUtil.scrollTop();
				} else {
					Swal.fire({
						text: "Sorry, looks like there are some errors detected, please try again.",
						icon: "error",
						buttonsStyling: false,
						confirmButtonText: "Ok, got it!",
						customClass: {
							confirmButton: "btn font-weight-bold btn-light"
						}
					}).then(function () {
						KTUtil.scrollTop();
					});
				}
			});
		});

		// Change event
		_wizard.on('change', function (wizard) {
			KTUtil.scrollTop();
		});
	}

	var initValidation = function () {
		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		// Step 1
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
                fields: {
                    billty_id: {
                        validators: {
                            notEmpty: {
                                message: 'Select Complain No....'
                            }
                        }
                    },
                    challan_id: {
                        validators: {
                            notEmpty: {
                                message: 'Challan No Select is required'
                            }
                        }
                    },
                    credit_note_amount: {
                        validators: {
                            notEmpty: {
                                message: 'Amount is required'
                            }
                        }
                    },
                    invoice_date: {
                        validators: {
                            notEmpty: {
                                message: 'Date is required'
                            }
                        }
                    },
                    transport_id: {
                        validators: {
                            notEmpty: {
                                message: 'Select Transport Name'
                            }
                        }
                    },
                    lr_no: {
                        validators: {
                            notEmpty: {
                                message: 'LR No is Required'
                            }
                        }
                    },
                    lory_no: {
                        validators: {
                            notEmpty: {
                                message: 'Lory No is Required'
                            }
                        }
                    },
                    authorize_person: {
                        validators: {
                            notEmpty: {
                                message: 'Person Name is Required'
                            }
                        }
                    },
                    mechanic_id: {
                        validators: {
                            notEmpty: {
                                message: 'Mechanic Name is Required'
                            }
                        }
                    },
                    // mechanic_id2: {
                    //     validators: {
                    //         notEmpty: {
                    //             message: 'Mechanic Name is Required'
                    //         }
                    //     }
                    // },
                    ta_da_amount: {
                        validators: {
                            notEmpty: {
                                message: 'Amount is Required'
                            }
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap()
                }
            }
		));

		// Step 2
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					category_id: {
						validators: {
							notEmpty: {
								message: 'Category Name is required'
							}
						}
					},
					product_id: {
						validators: {
							notEmpty: {
								message: 'product  is required'
							},

						}
					},
					brand_id: {
						validators: {
							notEmpty: {
								message: 'City is required'
							},
							// digits: {
							// 	message: 'The value added is not valid'
							// }
						}
					},
					packing_type: {
						validators: {
							notEmpty: {
								message: 'Package Type is required'
							},
						}
					},
                    bill_no: {
						validators: {
							notEmpty: {
								message: 'Bill Number is required'
							},

						}
					},
                    serial_no: {
						validators: {
							notEmpty: {
								message: 'Serial No is required'
							},

						}
					},
                    warranty: {
						validators: {
							notEmpty: {
								message: 'Warranty is required'
							},

						}
					},
                    bill_date: {
                        validators: {
                            notEmpty: {
                                message: 'Bill Date is required'
                            },

                        }
                    },
                    application: {
                        validators: {
                            notEmpty: {
                                message: 'Application is required'
                            },

                        }
                    },
                    hour_run: {
                        validators: {
                            notEmpty: {
                                message: 'Hour is required'
                            },

                        }
                    },
                    spare_id: {
                        validators: {
                            notEmpty: {
                                message: 'Sapre is required'
                            },

                        }
                    }
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));

		// Step 3
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
                    accessories_id: {
						validators: {
							notEmpty: {
								message: 'Accessories is required'
							}
						}
					},
                    accessories_qty: {
						validators: {
							notEmpty: {
								message: 'quantity is required'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));

		// Step 4
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
                    product_id: {
						validators: {
							notEmpty: {
								message: 'Panel is required'
							}
						}
					},
                    panel_qty: {
						validators: {
							notEmpty: {
								message: 'Quantity is required'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));
	}

	return {
		// public functions
		init: function () {
			_wizardEl = KTUtil.getById('kt_wizard_v1');
			_formEl = KTUtil.getById('kt_form');

			initWizard();
			initValidation();
		}
	};
}();

jQuery(document).ready(function () {
	KTWizard1.init();
});
