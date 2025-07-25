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
                            {{ $coinmarketcal ? $coinmarketcal->fullname : ($coin.' '.$symbol) }} - Trendings
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
                                <div class="p-5 m-stack m-stack--ver m-stack--desktop m-stack--demo">
                                    {!! $trendingsText !!}
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