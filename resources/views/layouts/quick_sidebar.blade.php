<!-- begin::Quick Sidebar -->
<div id="m_quick_sidebar" class="m-quick-sidebar m-quick-sidebar--tabbed m-quick-sidebar--skin-light">
    <div class="m-quick-sidebar__content m--hide">
				<span id="m_quick_sidebar_close" class="m-quick-sidebar__close">
					<i class="la la-close"></i>
				</span>
        <ul id="m_quick_sidebar_tabs" class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--brand" role="tablist">
            <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_quick_sidebar_tabs_messenger" role="tab">
                    Messages
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active m-scrollable" id="m_quick_sidebar_tabs_messenger" role="tabpanel">
                <div class="m-messenger m-messenger--message-arrow m-messenger--skin-light">
                    <!--begin::Preview-->
                    <div class="m-demo">
                        <div class="m-demo__preview">
                            <div class="m-list-timeline">
                                <div class="m-scrollable mCustomScrollbar _mCS_3 mCS-autoHide" data-scrollbar-shown="true" data-scrollable="true" data-max-height="200" style="max-height: 200px; height: 200px; position: relative; overflow: visible;">
                                    <div class="m-list-timeline__items" id="timeline">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Preview-->

                    <div id="content"></div>
                    <span id="status">Connecting...</span>
                    <div class="col-lg-12" style="padding-top: 30px;">
                        <textarea name="content" class="form-control" data-provide="markdown" rows="10" id="textarea" ></textarea>
                        <button type="button" class="btn btn-primary" id="user_message">
                            Submit
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- end::Quick Sidebar -->

<script>

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>