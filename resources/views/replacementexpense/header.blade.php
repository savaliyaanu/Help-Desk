<div class="wizard-nav border-bottom">
    <div class="wizard-steps p-8 ">
        <!--begin::Wizard Step 1 Nav-->
        <div class="wizard-step" data-wizard-state="{{ ($pageType =='Service Expense')?'current':'' }}">
                        <a href="{{ route('service-expense.create') }}">
            <div class="wizard-label">
                <i class="wizard-icon flaticon-list"></i>
                <h3 class="wizard-title">1. Service Expense</h3>
            </div>
                        </a>
            <span class="svg-icon svg-icon-xl wizard-arrow">
															<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                     height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24"/>
                        <rect fill="#000000" opacity="0.3"
                              transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)"
                              x="11" y="5" width="2" height="14" rx="1"/>
                        <path
                            d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z"
                            fill="#000000" fill-rule="nonzero"
                            transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)"/>
                    </g>
                </svg>
                <!--end::Svg Icon-->
            </span>
        </div>
        <!--end::Wizard Step 1 Nav-->
        <!--begin::Wizard Step 2 Nav-->
        <div class="wizard-step" data-wizard-state="{{ ($pageType =='Party')?'current':'' }}">
                        <a href="{{ route('party.create') }}">
            <div class="wizard-label">
                <i class=" wizard-icon flaticon-avatar"></i>
                <h3 class="wizard-title">2. Add Item</h3>
            </div>
                        </a>
            <span class="svg-icon svg-icon-xl wizard-arrow">
															<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
															<svg xmlns="http://www.w3.org/2000/svg"
                                                                 xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                                 height="24px" viewBox="0 0 24 24" version="1.1">
																<g stroke="none" stroke-width="1" fill="none"
                                                                   fill-rule="evenodd">
																	<polygon points="0 0 24 0 24 24 0 24"/>
																	<rect fill="#000000" opacity="0.3"
                                                                          transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)"
                                                                          x="11" y="5" width="2" height="14" rx="1"/>
																	<path
                                                                        d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z"
                                                                        fill="#000000" fill-rule="nonzero"
                                                                        transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)"/>
																</g>
															</svg>
                <!--end::Svg Icon-->
														</span>
        </div>
        <!--end::Wizard Step 2 Nav-->
        <!--begin::Wizard Step 3 Nav-->
        <div class="wizard-step" data-wizard-state="{{ ($pageType =='Other Expense')?'current':'' }}">
                        <a href="{{ route('other-expense.create') }}">
            <div class="wizard-label">
                <i class="wizard-icon flaticon-list-1"></i>
                <h3 class="wizard-title">3. Other Expense</h3>
            </div>
                        </a>
            <span class="svg-icon svg-icon-xl wizard-arrow">
															<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
															<svg xmlns="http://www.w3.org/2000/svg"
                                                                 xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                                 height="24px" viewBox="0 0 24 24" version="1.1">
																<g stroke="none" stroke-width="1" fill="none"
                                                                   fill-rule="evenodd">
																	<polygon points="0 0 24 0 24 24 0 24"/>
																	<rect fill="#000000" opacity="0.3"
                                                                          transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)"
                                                                          x="11" y="5" width="2" height="14" rx="1"/>
																	<path
                                                                        d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z"
                                                                        fill="#000000" fill-rule="nonzero"
                                                                        transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)"/>
																</g>
															</svg>
                <!--end::Svg Icon-->
														</span>
        </div>
        <!--end::Wizard Step 3 Nav-->
        <!--begin::Wizard Step 5 Nav-->
        <div class="wizard-step" data-wizard-state="{{ ($pageType =='Traveling')?'current':'' }}">
                        <a href="{{ route('traveling-expense.create') }}">
            <div class="wizard-label">
                <i class="wizard-icon flaticon-bus-stop "></i>
                <h3 class="wizard-title">4. Traveling Detail</h3>
            </div>
                        </a>
            <span class="svg-icon svg-icon-xl wizard-arrow last">
															<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
															<svg xmlns="http://www.w3.org/2000/svg"
                                                                 xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                                 height="24px" viewBox="0 0 24 24" version="1.1">
																<g stroke="none" stroke-width="1" fill="none"
                                                                   fill-rule="evenodd">
																	<polygon points="0 0 24 0 24 24 0 24"/>
																	<rect fill="#000000" opacity="0.3"
                                                                          transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)"
                                                                          x="11" y="5" width="2" height="14" rx="1"/>
																	<path
                                                                        d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z"
                                                                        fill="#000000" fill-rule="nonzero"
                                                                        transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)"/>
																</g>
															</svg>
                <!--end::Svg Icon-->
														</span>
        </div>
        <!--end::Wizard Step 5 Nav-->
    </div>
</div>
