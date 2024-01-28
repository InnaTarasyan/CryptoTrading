<!--Begin::Section-->
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="m-portlet m-portlet--accent m-portlet--head-solid-bg m-portlet--head-sm" data-portlet="true" id="m_portlet_tools_4">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                                    <span class="m-portlet__head-icon">
                                       <i class="flaticon-coins"></i>
                                    </span>
                        <h3 class="m-portlet__head-text">
                            {{ $coinmarketcal ? $coinmarketcal->fullname : ($coin.' '.$symbol) }} - NFTS
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="" data-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon" title="" data-original-title="Collapse">
                                <i class="la la-angle-down"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body" style="padding: 0rem;">
                <!--begin::Section-->
                <div class="m-section">
                    <div class="m-section__content">
                        <div class="m-demo" data-code-preview="true" data-code-html="true" data-code-js="false">
                            <div class="m-demo__preview">
                                <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                    <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                            <b> Contract Address </b>
                                        </div>
                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                            {{ 	$nfts->contract_address }}
                                        </div>
                                    </div>
                                    <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                            <b> Name </b>
                                        </div>
                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                            {{ 	$nfts->name }}
                                        </div>
                                    </div>
                                    <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                            <b> Asset platform id </b>
                                        </div>
                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                            {{ 	$nfts->asset_platform_id }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Section-->
            </div>
        </div>
    </div>
</div>