// Class definition
var KTFormControls = function () {
    // Private functions
    var _initDemo1 = function () {
        FormValidation.formValidation(
            document.getElementById('kt_form_1'),
            {
                fields: {
                    assign_id: {
                        validators: {
                            notEmpty: {
                                message: 'User Name is required'
                            }
                        }
                    },
                    complain_id: {
                        validators: {
                            notEmpty: {
                                message: 'Complain no is required'
                            }
                        }
                    },
                    company_id: {
                        validators: {
                            notEmpty: {
                                message: 'Select Company Name'
                            }
                        }
                    }, branch_id: {
                        validators: {
                            notEmpty: {
                                message: 'Select Branch Name'
                            }
                        }
                    }, role_id: {
                        validators: {
                            notEmpty: {
                                message: 'Select Role Name'
                            }
                        }
                    },

                    complain_type: {
                        validators: {
                            notEmpty: {
                                message: 'Complain Type is required'
                            },
                            // uri: {
                            // 	message: 'The website address is not valid'
                            // }
                        }
                    },

                    // client_id: {
                    // 	validators: {
                    // 		notEmpty: {
                    // 			message: 'Client Name is required'
                    // 		},
                    // 		// digits: {
                    // 		// 	message: 'The velue is not a valid digits'
                    // 		// }
                    // 	}
                    // },

                    transport_id: {
                        validators: {
                            notEmpty: {
                                message: 'Transport Name is required'
                            },
                            // digits: {
                            // 	message: 'The velue is not a valid digits'
                            // }
                        }
                    },

                    freight_rs: {
                        validators: {
                            notEmpty: {
                                message: 'Freight Rs. is required'
                            },
                            digits: {
                                message: 'The value is not a valid digits'
                            }
                        }
                    },

                    lr_no: {
                        validators: {
                            notEmpty: {
                                message: 'Lr No is Required'
                            },
                            // digits: {
                            // 	message: 'The value is not a valid digits'
                            // }
                        }
                    },

                    billty_id: {
                        validators: {
                            notEmpty: {
                                message: 'Select Complain No..'
                            }
                        }
                    },
                    address: {
                        validators: {
                            notEmpty: {
                                message: 'Address is Required'
                            }
                        }
                    },
                    company_name: {
                        validators: {
                            notEmpty: {
                                message: 'Company Name is Required'
                            }
                        }
                    },
                    lr_date: {
                        validators: {
                            notEmpty: {
                                message: 'Lr Date is Required'
                            }
                        }
                    },
                    entry_by: {
                        validators: {
                            notEmpty: {
                                message: 'Entry By Name is Required'
                            }
                        }
                    },
                    city_id: {
                        validators: {
                            notEmpty: {
                                message: 'Select City is Required'
                            }
                        }
                    },
                    pincode: {
                        validators: {
                            notEmpty: {
                                message: 'PinCode is Required'
                            }
                        }
                    },
                    email: {
                        validators: {
                            notEmpty: {
                                message: 'Email is Required'
                            }
                        }
                    },
                    phone: {
                        validators: {
                            notEmpty: {
                                message: 'Mobile No is Required'
                            }
                        }
                    }
                },

                plugins: { //Learn more: https://formvalidation.io/guide/plugins
                    trigger: new FormValidation.plugins.Trigger(),
                    // Bootstrap Framework Integration
                    bootstrap: new FormValidation.plugins.Bootstrap(),
                    // Validate fields when clicking the Submit button
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    // Submit the form when all fields are valid
                    defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                }
            }
        );
    }

    var _initDemo2 = function () {
        FormValidation.formValidation(
            document.getElementById('kt_form_2'),
            {
                fields: {
                    billing_card_name: {
                        validators: {
                            notEmpty: {
                                message: 'Card Holder Name is required'
                            }
                        }
                    },
                    billing_card_number: {
                        validators: {
                            notEmpty: {
                                message: 'Credit card number is required'
                            },
                            creditCard: {
                                message: 'The credit card number is not valid'
                            }
                        }
                    },
                    billing_card_exp_month: {
                        validators: {
                            notEmpty: {
                                message: 'Expiry Month is required'
                            }
                        }
                    },
                    billing_card_exp_year: {
                        validators: {
                            notEmpty: {
                                message: 'Expiry Year is required'
                            }
                        }
                    },
                    billing_card_cvv: {
                        validators: {
                            notEmpty: {
                                message: 'CVV is required'
                            },
                            digits: {
                                message: 'The CVV velue is not a valid digits'
                            }
                        }
                    },

                    billing_address_1: {
                        validators: {
                            notEmpty: {
                                message: 'Address 1 is required'
                            }
                        }
                    },
                    billing_city: {
                        validators: {
                            notEmpty: {
                                message: 'City 1 is required'
                            }
                        }
                    },
                    billing_state: {
                        validators: {
                            notEmpty: {
                                message: 'State 1 is required'
                            }
                        }
                    },
                    billing_zip: {
                        validators: {
                            notEmpty: {
                                message: 'Zip Code is required'
                            },
                            zipCode: {
                                country: 'US',
                                message: 'The Zip Code value is invalid'
                            }
                        }
                    },

                    billing_delivery: {
                        validators: {
                            choice: {
                                min: 1,
                                message: 'Please kindly select delivery type'
                            }
                        }
                    },
                    package: {
                        validators: {
                            choice: {
                                min: 1,
                                message: 'Please kindly select package type'
                            }
                        }
                    }
                },

                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    // Validate fields when clicking the Submit button
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    // Submit the form when all fields are valid
                    defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                    // Bootstrap Framework Integration
                    bootstrap: new FormValidation.plugins.Bootstrap({
                        eleInvalidClass: '',
                        eleValidClass: '',
                    })
                }
            }
        );
    }

    return {
        // public functions
        init: function () {
            _initDemo1();
            _initDemo2();
        }
    };
}();

jQuery(document).ready(function () {
    KTFormControls.init();
});
