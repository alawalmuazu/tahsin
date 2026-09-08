<aside id="sidebar-left" class="sidebar-left">
    <div class="sidebar-header">
        <div class="sidebar-title">
            Main
        </div>
    </div>

    <div class="nano">
        <div class="nano-content">
            <nav id="menu" class="nav-main" role="navigation">
                <ul class="nav nav-main">
                    <!-- dashboard -->
                    <?php if (is_superadmin_loggedin() || is_state_executive_loggedin()) { ?>
                    <li class="nav-parent <?php if ($main_menu == 'dashboard' || $main_menu == 'state_analytics') echo 'nav-active nav-expanded';?>">
                        <a>
                            <i class="icons icon-grid"></i><span><?=translate('dashboard')?></span>
                        </a>
                        <ul class="nav nav-children">
                            <li class="<?php if ($main_menu == 'state_analytics') echo 'nav-active';?>">
                                <a href="<?=base_url('state_analytics')?>">
                                    <span><i class="fas fa-chart-line" aria-hidden="true"></i> State Analytics</span>
                                </a>
                            </li>
                            <?php if (is_superadmin_loggedin()): ?>
                            <li class="<?php if ($main_menu == 'state_analytics_lga') echo 'nav-active';?>">
                                <a href="<?=base_url('state_analytics/lga_report')?>">
                                    <span><i class="fas fa-map-marker-alt" aria-hidden="true"></i> LGA Report</span>
                                </a>
                            </li>
                            <li class="<?php if ($main_menu == 'health') echo 'nav-active';?>">
                                <a href="<?=base_url('health')?>">
                                    <span><i class="fas fa-heartbeat" aria-hidden="true"></i> System Health</span>
                                </a>
                            </li>
                            <?php endif; ?>
                        <?php $school_id = $this->input->get('school_id'); ?>
                            <!-- All Branches: summary link -->
                            <li class="<?php if ($main_menu == 'dashboard' && empty($school_id)) echo 'nav-active';?>">
                                <a href="<?=base_url('dashboard')?>">
                                    <span><i class="fas fa-layer-group" aria-hidden="true"></i> <?=translate('all_branches')?></span>
                                </a>
                            </li>

                            <!-- Live School Search (replaces the 2000+ branch list) -->
                            <li class="nav-school-search" style="padding:6px 10px 8px;">
                                <?php
                                // Show current school label if one is active
                                if (!empty($school_id)) {
                                    $active_school = $this->db->select('name')->where('id', $school_id)->get('branch')->row();
                                    if ($active_school): ?>
                                <div style="font-size:11px;color:#aaa;margin-bottom:4px;padding-left:2px;">
                                    <i class="fas fa-map-marker-alt" style="color:#4caf50"></i>
                                    <strong style="color:#ddd"><?=html_escape($active_school->name)?></strong>
                                    <a href="<?=base_url('dashboard')?>" title="Clear" style="color:#e57373;margin-left:4px;font-size:10px">✕</a>
                                </div>
                                <?php endif; } ?>
                                <div style="position:relative">
                                    <input type="text"
                                           id="school-sidebar-search"
                                           placeholder="🔍 Search school…"
                                           autocomplete="off"
                                           style="width:100%;padding:5px 8px;font-size:12px;border-radius:5px;
                                                  border:1px solid #444;background:#2a2a3a;color:#ddd;outline:none;">
                                    <ul id="school-sidebar-results"
                                        style="display:none;position:absolute;left:0;right:0;top:100%;
                                               background:#1e1e2e;border:1px solid #444;border-top:none;
                                               border-radius:0 0 6px 6px;max-height:220px;overflow-y:auto;
                                               list-style:none;padding:0;margin:0;z-index:9999;
                                               box-shadow:0 6px 20px rgba(0,0,0,.5)">
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <script>
                    (function(){
                        var inp = document.getElementById('school-sidebar-search');
                        var res = document.getElementById('school-sidebar-results');
                        if (!inp) return;
                        var timer;

                        inp.addEventListener('input', function(){
                            clearTimeout(timer);
                            var q = this.value.trim();
                            if (q.length < 2) { res.style.display = 'none'; res.innerHTML = ''; return; }

                            timer = setTimeout(function(){
                                res.innerHTML = '<li style="padding:8px 12px;color:#888;font-size:12px">Searching…</li>';
                                res.style.display = 'block';

                                fetch('<?=base_url('dashboard/search_branch')?>?q=' + encodeURIComponent(q))
                                    .then(function(r){ return r.json(); })
                                    .then(function(data){
                                        if (!data.length) {
                                            res.innerHTML = '<li style="padding:8px 12px;color:#888;font-size:12px">No schools found</li>';
                                            return;
                                        }
                                        res.innerHTML = data.map(function(s){
                                            return '<li data-id="'+s.id+'" style="padding:7px 12px;font-size:12px;cursor:pointer;'
                                                + 'border-bottom:1px solid #333;color:#ccc;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"'
                                                + ' onmouseover="this.style.background=\'#2d4a3e\'" onmouseout="this.style.background=\'\'">'+
                                                '<i class="fas fa-school" style="color:#4caf50;margin-right:6px;font-size:10px"></i>'
                                                + s.name + (s.lga ? ' <small style="color:#888">· '+s.lga+'</small>' : '')
                                                + '</li>';
                                        }).join('');

                                        res.querySelectorAll('li[data-id]').forEach(function(li){
                                            li.addEventListener('click', function(){
                                                window.location.href = '<?=base_url('dashboard/index')?>?school_id=' + this.dataset.id;
                                            });
                                        });
                                    })
                                    .catch(function(){
                                        res.innerHTML = '<li style="padding:8px 12px;color:#e57373;font-size:12px">Error loading results</li>';
                                    });
                            }, 250);
                        });

                        // Close on click outside
                        document.addEventListener('click', function(e){
                            if (!inp.contains(e.target) && !res.contains(e.target)) {
                                res.style.display = 'none';
                            }
                        });
                    })();
                    </script>

                    <?php } else { ?>
                            <li class="<?php if ($main_menu == 'dashboard') echo 'nav-active'; ?>">
                                <a href="<?=base_url('dashboard')?>">
                                    <i class="icons icon-grid"></i><span><?=translate('dashboard')?></span>
                                </a>
                            </li>
                    <?php } ?>

                    <?php if (!get_permission('teacher_transfer', 'is_view') && loggedin_role_id() != 6 && loggedin_role_id() != 7) : ?>
                    <!-- Self-Service Staff Transfer -->
                    <li class="<?php if ($main_menu == 'teacher_transfer') echo 'nav-active';?>">
                        <a href="<?=base_url('teacher_transfer')?>">
                            <i class="fas fa-exchange-alt"></i><span>Transfer Request</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if (moduleIsEnabled('inventory')) { 
                        if (get_permission('product', 'is_view') ||
                            get_permission('product_category', 'is_view') ||
                            get_permission('product_store', 'is_view') ||
                            get_permission('product_supplier', 'is_view') ||
                            get_permission('product_unit', 'is_view') ||
                            get_permission('product_purchase', 'is_view') ||
                            get_permission('product_sales', 'is_view') ||
                            get_permission('product_issue', 'is_view')) {
                        ?>
                    <!-- School Assets (formerly Inventory) -->
                    <li class="nav-parent <?php if ($main_menu == 'inventory' || $main_menu == 'inventory_report' || $main_menu == 'infrastructure') echo 'nav-expanded nav-active'; ?>">
                        <a><i class="fas fa-dolly"></i><span>School Assets</span></a>
                        <ul class="nav nav-children">
                        <?php if(get_permission('product', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'inventory/product' || $sub_page == 'inventory/product_edit') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('inventory/product'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?php echo translate('product'); ?></span>
                                </a>
                            </li>
                        <?php } if(get_permission('product_category', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'inventory/category') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('inventory/category'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?php echo translate('category'); ?></span>
                                </a>
                            </li>
                        <?php } if(get_permission('product_store', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'inventory/store' || $sub_page == 'inventory/store_edit') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('inventory/store'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?php echo translate('store'); ?></span>
                                </a>
                            </li>
                        <?php } if(get_permission('product_supplier', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'inventory/supplier' || $sub_page == 'inventory/supplier_edit') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('inventory/supplier'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?php echo translate('supplier'); ?></span>
                                </a>
                            </li>
                        <?php } if(get_permission('product_unit', 'is_view')){  ?>
                            <li class="<?php if ($sub_page == 'inventory/unit') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('inventory/unit'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?php echo translate('unit'); ?></span>
                                </a>
                            </li>
                        <?php } if(get_permission('product_purchase', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'inventory/purchase' || $sub_page == 'inventory/purchase_edit' || $sub_page == 'inventory/purchase_bill') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('inventory/purchase'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?php echo translate('purchase'); ?></span>
                                </a>
                            </li>
                        <?php } if(get_permission('product_sales', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'inventory/sales' || $sub_page == 'inventory/sales_invoice') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('inventory/sales'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?php echo translate('sales'); ?></span>
                                </a>
                            </li>
                        <?php } if(get_permission('product_issue', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'inventory/issue') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('inventory/issue'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?php echo translate('issue'); ?></span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (is_superadmin_loggedin() || is_state_executive_loggedin() || is_admin_loggedin()): ?>
                            <li class="<?php if ($main_menu == 'infrastructure') echo 'nav-active'; ?>">
                                <a href="<?=base_url('infrastructure')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i> Infrastructure</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        </ul>
                    </li>
                    <?php } } ?>
                    <?php
                    if (is_superadmin_loggedin()) : ?>
                    <!-- Administration (Branch + Education Board) -->
                    <li class="nav-parent <?php if ($main_menu == 'branch' || $main_menu == 'education_board') echo 'nav-expanded nav-active'; ?>">
                        <a><i class="fas fa-landmark"></i><span>Administration</span></a>
                        <ul class="nav nav-children">
                            <li class="<?php if ($main_menu == 'branch') echo 'nav-active';?>">
                                <a href="<?=base_url('branch')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?=translate('branch')?></span>
                                </a>
                            </li>
                            <li class="<?php if ($main_menu == 'education_board') echo 'nav-active';?>">
                                <a href="<?=base_url('education_board')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>Education Board</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <?php endif;
                    if (is_superadmin_loggedin() || is_state_executive_loggedin()) : ?>
                    <!-- State Quality Assurance -->
                    <li class="nav-parent <?php if ($main_menu == 'teacher_transfer' || $main_menu == 'school_inspection') echo 'nav-expanded nav-active'; ?>">
                        <a><i class="fas fa-check-double"></i><span>State Quality Assurance</span></a>
                        <ul class="nav nav-children">
                            <li class="<?php if ($main_menu == 'teacher_transfer') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('teacher_transfer'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>Teacher Transfers</span>
                                </a>
                            </li>
                            <li class="<?php if ($main_menu == 'school_inspection') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('school_inspection'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>School Inspections</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <?php endif;
                    /* NEMIS Reports moved into Reports menu — see below */
                    ?>
                    <?php $saasExisting = $this->app_lib->isExistingAddon('saas');
                    if ($saasExisting): ?>
                    <!-- School Subscription (SaaS)  -->
                        <?php include "saas_menu.php"; ?>
                    <?php endif; ?>
                    <?php 
                    $u2FAExisting = $this->app_lib->isExistingAddon('two_fa');
                    if ($u2FAExisting) { 
                        if (moduleIsEnabled('two_fa')) { ?>
                    <!-- Two Factor Authenticator  -->
                        <?php include "tfa_menu.php"; ?>
                    <?php } } ?>
                    <?php
                    if (moduleIsEnabled('website')) {
                        if (get_permission('frontend_setting', 'is_view') ||
                            get_permission('frontend_menu', 'is_view') ||
                            get_permission('frontend_section', 'is_view') ||
                            get_permission('manage_page', 'is_view') ||
                            get_permission('frontend_slider', 'is_view') ||
                            get_permission('frontend_features', 'is_view') ||
                            get_permission('frontend_testimonial', 'is_view') ||
                            get_permission('frontend_services', 'is_view') ||
                            get_permission('frontend_gallery', 'is_view') ||
                            get_permission('frontend_gallery_category', 'is_view') ||
                            get_permission('frontend_news', 'is_view') ||
                            get_permission('frontend_faq', 'is_view')) {
                            ?>
                    <!-- Patient Details -->
                    <li class="nav-parent <?php if ($main_menu == 'frontend') echo 'nav-expanded nav-active'; ?>">
                        <a><i class="fas fa-globe"></i><span><?php echo translate('frontend'); ?></span></a>
                        <ul class="nav nav-children">
                        <?php if(get_permission('frontend_setting', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'frontend/setting') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('frontend/setting'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?php echo translate('setting'); ?></span>
                                </a>
                            </li>
                       <?php } if(get_permission('frontend_menu', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'frontend/menu' || $sub_page == 'frontend/menu_edit') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('frontend/menu'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?php echo translate('menu'); ?></span>
                                </a>
                            </li>
                        <?php } if(get_permission('frontend_section', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'frontend/section_home' ||
                                            $sub_page == 'frontend/section_doctors' ||
                                                $sub_page == 'frontend/section_appointment' ||
                                                    $sub_page == 'frontend/section_faq' ||
                                                        $sub_page == 'frontend/section_contact' ||
                                                            $sub_page == 'frontend/section_about' ||
                                                                $sub_page == 'frontend/section_services') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('frontend/section/index'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?php echo translate('page') . " " . translate('section'); ?></span>
                                </a>
                            </li>
                            <?php } if(get_permission('manage_page', 'is_view')){ ?>
                                    <li class="<?php if ($sub_page == 'frontend/content' || $sub_page == 'frontend/content_edit') echo 'nav-active'; ?>">
                                        <a href="<?php echo base_url('frontend/content/index'); ?>">
                                            <span><i class="fas fa-caret-right" aria-hidden="true"></i><?php echo translate('manage') . " " . translate('page'); ?></span>
                                        </a>
                                    </li>
                            <?php } if(get_permission('frontend_slider', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'frontend/slider' || $sub_page == 'frontend/slider_edit') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('frontend/slider'); ?>">
                                    <span><i class="fas fa-caret-right"></i><?php echo translate('slider'); ?></span>
                                </a>
                            </li>
                            <?php } if(get_permission('frontend_features', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'frontend/features' || $sub_page == 'frontend/features_edit') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('frontend/features'); ?>">
                                    <span><i class="fas fa-caret-right"></i><?php echo translate('features'); ?></span>
                                </a>
                            </li>
                            <?php } if(get_permission('frontend_testimonial', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'frontend/testimonial' || $sub_page == 'frontend/testimonial_edit') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('frontend/testimonial'); ?>">
                                    <span><i class="fas fa-caret-right"></i><?php echo translate('testimonial'); ?></span>
                                </a>
                            </li>
                            <?php } if(get_permission('frontend_services', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'frontend/services' || $sub_page == 'frontend/services_edit') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('frontend/services'); ?>">
                                    <span><i class="fas fa-caret-right"></i><?php echo translate('service'); ?></span>
                                </a>
                            </li>
                            <?php } if(get_permission('frontend_faq', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'frontend/faq' || $sub_page == 'frontend/faq_edit') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('frontend/faq/index'); ?>">
                                    <span><i class="fas fa-caret-right"></i><?php echo translate('faq'); ?></span>
                                </a>
                            </li>
                            <?php } if(get_permission('frontend_gallery_category', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'frontend/gallery_category') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('frontend/gallery/category'); ?>">
                                    <span><i class="fas fa-caret-right"></i><?php echo translate('gallery') . " " . translate('category'); ?></span>
                                </a>
                            </li>
                            <?php } if(get_permission('frontend_gallery', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'frontend/gallery' || $sub_page == 'frontend/gallery_edit' || $sub_page == 'frontend/gallery_album') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('frontend/gallery/index'); ?>">
                                    <span><i class="fas fa-caret-right"></i><?php echo translate('gallery'); ?></span>
                                </a>
                            </li>
                            <?php } if(get_permission('frontend_news', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'frontend/news' || $sub_page == 'frontend/news_edit') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('frontend/news/index'); ?>">
                                    <span><i class="fas fa-caret-right"></i><?php echo translate('news'); ?></span>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php }} ?>

                    <?php
                    if (moduleIsEnabled('reception')) {
                        if (get_permission('postal_record', 'is_view') ||
                        get_permission('call_log', 'is_view') ||
                        get_permission('visitor_log', 'is_view') ||
                        get_permission('complaint', 'is_view') ||
                        get_permission('enquiry', 'is_view') ||
                        get_permission('follow_up', 'is_view') ||
                        get_permission('config_reception', 'is_view')) { 
                        ?>
                    <!-- reception -->
                    <li class="nav-parent <?php if ($main_menu == 'reception') echo 'nav-expanded nav-active';?>">
                        <a>
                            <i class="fas fa-users-line"></i><span><?=translate('reception')?></span>
                        </a>
                        <ul class="nav nav-children">
                            <?php if(get_permission('enquiry', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'reception/enquiry' || $sub_page =='reception/enquiry_edit' || $sub_page =='reception/enquiry_details') echo 'nav-active';?>">
                                <a href="<?=base_url('reception/enquiry')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?=translate('admission_enquiry')?></span>
                                </a>
                            </li>
                            <?php } if(get_permission('postal_record', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'reception/postal' || $sub_page =='reception/postal_edit') echo 'nav-active';?>">
                                <a href="<?=base_url('reception/postal')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?=translate('postal_record')?></span>
                                </a>
                            </li>
                            <?php } if(get_permission('call_log', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'reception/call_log' || $sub_page =='reception/call_log_edit') echo 'nav-active';?>">
                                <a href="<?=base_url('reception/call_log')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?=translate('call_log')?></span>
                                </a>
                            </li>
                            <?php } if(get_permission('visitor_log', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'reception/visitor' || $sub_page =='reception/visitor_edit') echo 'nav-active';?>">
                                <a href="<?=base_url('reception/visitor_log')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?=translate('visitor_log')?></span>
                                </a>
                            </li>
                            <?php } if(get_permission('complaint', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'reception/complaint' || $sub_page == 'reception/complaint_edit') echo 'nav-active';?>">
                                <a href="<?=base_url('reception/complaint')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?=translate('complaint')?></span>
                                </a>
                            </li>
                            <?php } if(get_permission('config_reception', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'reception_config/reference' || $sub_page == 'reception_config/response' || $sub_page == 'reception_config/calling_purpose' || $sub_page == 'reception_config/visiting_purpose' || $sub_page == 'reception_config/complaint_type') echo 'nav-active';?>">
                                <a href="<?=base_url('reception_config/reference')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i> Config Reception</span>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php }} ?>

                    <?php
                    if (get_permission('student', 'is_add') ||
                        get_permission('multiple_import', 'is_add') ||
                        get_permission('online_admission', 'is_view') ||
                        get_permission('student_category', 'is_view')) { 
                            ?>
                    <!-- admission -->
                    <li class="nav-parent <?php if ($main_menu == 'admission') echo 'nav-expanded nav-active';?>">
                        <a>
                            <i class="far fa-edit"></i><span><?=translate('admission')?></span>
                        </a>
                        <ul class="nav nav-children">
                        <?php if(get_permission('student', 'is_add')){ ?>
                            <li class="<?php if ($sub_page == 'student/add') echo 'nav-active';?>">
                                <a href="<?=base_url('student/add')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?=translate('create_admission')?></span>
                                </a>
                            </li>
                        <?php } if(get_permission('online_admission', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'online_admission/index' || $sub_page =='online_admission/approved') echo 'nav-active';?>">
                                <a href="<?=base_url('online_admission/index')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?=translate('online_admission')?></span>
                                </a>
                            </li>
                        <?php } 
                        if (moduleIsEnabled('multi_class')) {
                            if(get_permission('multi_class', 'is_add')) { ?>

                            <li class="<?php if ($sub_page == 'multiclass/index') echo 'nav-active';?>">
                                <a href="<?=base_url('multiclass/index')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?=translate('multi_class')?></span>
                                </a>
                            </li>
                        <?php } } if(get_permission('multiple_import', 'is_add')){ ?>
                            <li class="<?php if ($sub_page == 'student/multi_add') echo 'nav-active';?>">
                                <a href="<?=base_url('student/csv_import')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?=translate('multiple_import')?></span>
                                </a>
                            </li>
                        <?php } if(get_permission('student', 'is_view')){ ?>
                            <li>
                                <a href="<?=base_url('student/csv_export')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?=translate('export')?> CSV</span>
                                </a>
                            </li>
                        <?php } if(get_permission('student_category', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'student/category') echo 'nav-active';?>">
                                <a href="<?=base_url('student/category')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?=translate('category')?></span>
                                </a>
                            </li>
                        <?php } ?>
                        </ul>
                    </li>
                    <?php } ?>

                    <?php
                    if (get_permission('student', 'is_view') ||
                    get_permission('student_disable_authentication', 'is_view')) {
                    ?>
                    <!-- student details -->
                    <li class="nav-parent <?php if ($main_menu == 'student') echo 'nav-expanded nav-active';?>">
                        <a>
                             <i class="icon-graduation icons"></i><span><?=translate('student_details')?></span>
                        </a>
                        <ul class="nav nav-children">
                        <?php if(get_permission('student', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'student/view' || $sub_page == 'student/profile') echo 'nav-active';?>">
                                <a href="<?=base_url('student/view')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?=translate('student_list')?></span>
                                </a>
                            </li>
                        <?php } if(get_permission('student_disable_authentication', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'student/disable_authentication') echo 'nav-active';?>">
                                <a href="<?=base_url('student/disable_authentication')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?=translate('login_deactivate')?></span>
                                </a>
                            </li>
                        <?php } if(get_permission('disable_reason', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'student/disable_reason') echo 'nav-active';?>">
                                <a href="<?=base_url('student/disable_reason')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?=translate('deactivate_reason')?></span>
                                </a>
                            </li>
                        <?php } ?>
                        </ul>
                    </li>
                    <?php } ?>
                    <?php
                    if (get_permission('parent', 'is_view') ||
                    get_permission('parent', 'is_add') ||
                    get_permission('parent_disable_authentication', 'is_view')) {
                    ?>
                    <!-- parents -->
                    <li class="nav-parent <?php if ($main_menu == 'parents') echo 'nav-expanded nav-active';?>">
                        <a>
                            <i class="icons icon-user-follow"></i><span><?=translate('parents')?></span>
                        </a>
                        <ul class="nav nav-children">
                        <?php if(get_permission('parent', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'parents/view' || $sub_page == 'parents/profile') echo 'nav-active';?>">
                                <a href="<?=base_url('parents/view')?>">
                                    <span><i class="fas fa-caret-right"></i><?=translate('parents_list')?></span>
                                </a>
                            </li>
                        <?php } if(get_permission('parent', 'is_add')){ ?>
                            <li class="<?php if ($sub_page == 'parents/add') echo 'nav-active';?>">
                                <a href="<?=base_url('parents/add')?>">
                                    <span><i class="fas fa-caret-right"></i><?=translate('add_parent')?></span>
                                </a>
                            </li>
                        <?php } if(get_permission('parent', 'is_add')){ ?>
                            <li class="<?php if ($sub_page == 'parents/csv_import') echo 'nav-active';?>">
                                <a href="<?=base_url('parents/csv_import')?>">
                                    <span><i class="fas fa-caret-right"></i><?=translate('multiple_import')?></span>
                                </a>
                            </li>
                        <?php } if(get_permission('parent', 'is_view')){ ?>
                            <li>
                                <a href="<?=base_url('parents/csv_export')?>">
                                    <span><i class="fas fa-caret-right"></i><?=translate('export')?> CSV</span>
                                </a>
                            </li>
                        <?php } if(get_permission('parent_disable_authentication', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'parents/disable_authentication') echo 'nav-active';?>">
                                <a href="<?=base_url('parents/disable_authentication')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?=translate('login_deactivate')?></span>
                                </a>
                            </li>
                        <?php } ?>
                        </ul>
                    </li>
                    <?php } ?>
                    <?php
                    if(get_permission('employee', 'is_view') ||
                    get_permission('employee', 'is_add') ||
                    get_permission('designation', 'is_view') ||
                    get_permission('designation', 'is_add') ||
                    get_permission('department', 'is_view') ||
                    get_permission('employee_disable_authentication', 'is_view')) {
                    ?>
                    <!-- Employees -->
                    <li class="nav-parent <?php if ($main_menu == 'employee') echo 'nav-expanded nav-active'; ?>">
                        <a><i class="fas fa-users"></i><span><?php echo translate('employee'); ?></span></a>
                        <ul class="nav nav-children">
                        <?php if(get_permission('employee', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'employee/view' ||  $sub_page == 'employee/profile' ) echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('employee/view'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?php echo translate('employee_list'); ?></span>
                                </a>
                            </li>
                        <?php } if(get_permission('department', 'is_view') || get_permission('department', 'is_add')){ ?>
                            <li class="<?php if ($sub_page == 'employee/department') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('employee/department'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?php echo translate('add_department'); ?></span>
                                </a>
                            </li>
                        <?php }  if(get_permission('designation', 'is_view') || get_permission('designation', 'is_add')){ ?>
                            <li class="<?php if ($sub_page == 'employee/designation') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('employee/designation'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?php echo translate('add_designation'); ?></span>
                                </a>
                            </li>
                        <?php } if(get_permission('employee', 'is_add')){ ?>
                            <li class="<?php if ($sub_page == 'employee/add') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('employee/add'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?php echo translate('add_employee'); ?></span>
                                </a>
                            </li>
                        <?php } if(get_permission('employee', 'is_add')){ ?>
                            <li class="<?php if ($sub_page == 'employee/csv_import') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('employee/csv_import'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?php echo translate('multiple_import'); ?></span>
                                </a>
                            </li>
                        <?php } if(get_permission('employee', 'is_view')){ ?>
                            <li>
                                <a href="<?php echo base_url('employee/csv_export'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?php echo translate('export'); ?> CSV</span>
                                </a>
                            </li>
                        <?php } if(get_permission('employee_disable_authentication', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'employee/disable_authentication') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('employee/disable_authentication'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?php echo translate('login_deactivate'); ?></span>
                                </a>
                            </li>
                        <?php } ?>
                        </ul>
                    </li>
                    <?php } ?>

                    <?php
                    if (moduleIsEnabled('card_management')) {
                        if(get_permission('id_card_templete', 'is_view') ||
                        get_permission('generate_student_idcard', 'is_view') ||
                        get_permission('admit_card_templete', 'is_view') ||
                        get_permission('generate_admit_card', 'is_view') ||
                        get_permission('generate_employee_idcard', 'is_view')) {
                        ?>
                    <li class="nav-parent <?php if ($main_menu == 'card_manage') echo 'nav-expanded nav-active';?>">
                        <a>
                            <i class="far fa-clipboard"></i><span><?=translate('card_management')?></span>
                        </a>
                        <ul class="nav nav-children">
                            <?php if(get_permission('id_card_templete', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'card_manage/id_card_templete' || $sub_page == 'card_manage/id_card_templete_edit') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('card_manage/id_card_templete'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?php echo translate('id_card') . " " .  translate('templete'); ?></span>
                                </a>
                            </li>
                            <?php } if(get_permission('generate_student_idcard', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'card_manage/generate_student_idcard') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('card_manage/generate_student_idcard'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?php echo translate('student') . " " .  translate('id_card'); ?></span>
                                </a>
                            </li>
                            <?php } if(get_permission('generate_employee_idcard', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'card_manage/generate_employee_idcard') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('card_manage/generate_employee_idcard'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?php echo translate('employee') . " " .  translate('id_card'); ?></span>
                                </a>
                            </li>
                            <?php } if(get_permission('admit_card_templete', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'card_manage/admit_card_templete' || $sub_page == 'card_manage/admit_card_templete_edit') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('card_manage/admit_card_templete'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?php echo translate('admit_card') . " " .  translate('templete'); ?></span>
                                </a>
                            </li>
                            <?php } if(get_permission('generate_admit_card', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'card_manage/generate_student_admitcard') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('card_manage/generate_student_admitcard'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?php echo translate('generate') . " " .  translate('admit_card'); ?></span>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php }} ?>
                    
                    <?php
                    if (moduleIsEnabled('certificate')) {
                        if(get_permission('certificate_templete', 'is_view') ||
                        get_permission('generate_student_certificate', 'is_view') ||
                        get_permission('generate_employee_certificate', 'is_view')) {
                        ?>
                    <li class="nav-parent <?php if ($main_menu == 'certificate') echo 'nav-expanded nav-active';?>">
                        <a>
                            <i class="icons icon-social-spotify"></i><span><?=translate('certificate')?></span>
                        </a>
                        <ul class="nav nav-children">
                            <?php if(get_permission('certificate_templete', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'certificate/index' || $sub_page == 'certificate/edit') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('certificate'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?php echo translate('certificate') . " " .  translate('templete'); ?></span>
                                </a>
                            </li>
                            <?php } if(get_permission('generate_student_certificate', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'certificate/generate_student') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('certificate/generate_student'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?php echo translate('generate') . " " .  translate('student'); ?></span>
                                </a>
                            </li>
                            <?php } if(get_permission('generate_employee_certificate', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'certificate/generate_employee') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('certificate/generate_employee'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?php echo translate('generate') . " " .  translate('employee'); ?></span>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php }} ?>
                    <?php
                    if (moduleIsEnabled('human_resource')) {
                        if(get_permission('salary_template', 'is_view') ||
                        get_permission('salary_assign', 'is_view') ||
                        get_permission('salary_payment', 'is_view') ||
                        get_permission('advance_salary_manage', 'is_view') ||
                        get_permission('advance_salary_request', 'is_view') ||
                        get_permission('leave_category', 'is_view') ||
                        get_permission('leave_category', 'is_add') ||
                        get_permission('leave_request', 'is_view') ||
                        get_permission('leave_manage', 'is_view') ||
                        get_permission('award', 'is_view')) {
                    ?>
                    <!-- human resource -->
                    <li class="nav-parent <?php if ($main_menu == 'payroll' || $main_menu == 'advance_salary' || $main_menu == 'leave' || $main_menu == 'award') echo 'nav-expanded nav-active';?>">
                        <a>
                            <i class="icons icon-loop"></i><span><?=translate('hrm')?></span>
                        </a>
                        <ul class="nav nav-children">
                            <?php
                            if(get_permission('salary_template', 'is_view') ||
                            get_permission('salary_assign', 'is_view') ||
                            get_permission('salary_payment', 'is_view')) {
                            ?>
                            <!-- payroll -->
                            <li class="nav-parent <?php if($main_menu == 'payroll') echo 'nav-expanded nav-active';?>">
                                <a>
                                    <i class="far fa-address-card" aria-hidden="true"></i>
                                    <span><?=translate('payroll')?></span>
                                </a>
                                <ul class="nav nav-children">
                                    <?php if(get_permission('salary_template', 'is_view')){ ?>
                                    <li class="<?php if ($sub_page == 'payroll/salary_templete' || $sub_page == 'payroll/salary_templete_edit') echo 'nav-active';?>">
                                        <a href="<?=base_url('payroll/salary_template')?>">
                                            <span><?=translate('salary_template')?></span>
                                        </a>
                                    </li>
                                    <?php } if(get_permission('salary_assign', 'is_view')){ ?>
                                    <li class="<?php if ($sub_page == 'payroll/salary_assign') echo 'nav-active';?>">
                                        <a href="<?=base_url('payroll/salary_assign')?>">
                                            <span><?=translate('salary_assign')?></span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                    <!-- salary_payment hidden: Kaduna staff are paid via IPPIS -->
                                </ul>
                            </li>
                            <?php } ?>
                            <?php
                            if(get_permission('advance_salary_manage', 'is_view') ||
                            get_permission('advance_salary_request', 'is_view')) {
                            ?>
                            <!-- advance salary managements -->
                            <li class="nav-parent <?php
                            if ($main_menu == 'advance_salary') echo 'nav-expanded nav-active';?>">
                                <a>
                                    <i class="fas fa-funnel-dollar" aria-hidden="true"></i>
                                    <span>Allowance Request</span>
                                </a>
                                <ul class="nav nav-children">
                                    <?php if(get_permission('advance_salary_request', 'is_view')){ ?>
                                    <li class="<?php if ($sub_page == 'advance_salary/request') echo 'nav-active';?>">
                                        <a href="<?=base_url('advance_salary/request')?>">
                                            <span><?=translate('my_application')?></span>
                                        </a>
                                    </li>
                                    <?php } if(get_permission('advance_salary_manage', 'is_view')){ ?>
                                    <li class="<?php if ($sub_page == 'advance_salary/index') echo 'nav-active';?>">
                                        <a href="<?=base_url('advance_salary')?>">
                                            <span><?=translate('manage_application')?></span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php } ?>
                            <?php
                            if(get_permission('leave_category', 'is_view') ||
                            get_permission('leave_manage', 'is_view') ||
                            get_permission('leave_request', 'is_view')) {
                            ?>
                            <!-- leave managements -->
                            <li class="nav-parent <?php
                            if ($main_menu == 'leave') echo 'nav-expanded nav-active';?>">
                                <a>
                                    <i class="fas fa-umbrella-beach" aria-hidden="true"></i>
                                    <span><?=translate('leave')?></span>
                                </a>
                                <ul class="nav nav-children">
                                <?php if(get_permission('leave_category', 'is_view')){ ?>
                                    <li class="<?php if ($sub_page == 'leave/category') echo 'nav-active';?>">
                                        <a href="<?=base_url('leave/category')?>">
                                            <span><?=translate('category')?></span>
                                        </a>
                                    </li>
                                <?php } if(get_permission('leave_request', 'is_view')){ ?>
                                    <li class="<?php if ($sub_page == 'leave/request') echo 'nav-active';?>">
                                        <a href="<?=base_url('leave/request')?>">
                                            <span><?=translate('my_application')?></span>
                                        </a>
                                    </li>
                                <?php } if(get_permission('leave_manage', 'is_view')){ ?>
                                    <li class="<?php if ($sub_page == 'leave/index') echo 'nav-active';?>">
                                        <a href="<?=base_url('leave')?>">
                                            <span><?=translate('manage_application')?></span>
                                        </a>
                                    </li>
                                <?php } ?>
                                </ul>
                            </li>
                            <?php } ?>
                            <?php if(get_permission('award', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'award/index' || $sub_page == 'award/edit') echo 'nav-active';?>">
                                 <a href="<?=base_url('award')?>">
                                     <i class="fas fa-crown"></i>
                                     <span><?=translate('award')?></span>
                                 </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php }} ?>
                    <?php
                    if(get_permission('classes', 'is_view') ||
                    get_permission('section', 'is_view') ||
                    get_permission('assign_class_teacher', 'is_view') ||
                    get_permission('subject', 'is_view') ||
                    get_permission('subject_class_assign', 'is_view') ||
                    get_permission('subject_teacher_assign', 'is_view') ||
                    get_permission('teacher_timetable', 'is_view') ||
                    get_permission('class_timetable', 'is_view')) {
                    ?>
                    <!-- academic -->
                    <li class="nav-parent <?php if ($main_menu == 'classes' ||
                                                        $main_menu == 'sections' ||
                                                            $main_menu == 'timetable' ||
                                                                $main_menu == 'subject' ||
                                                                    $main_menu == 'transfer') echo 'nav-expanded nav-active';?>">
                        <a>
                            <i class="icons icon-home" aria-hidden="true"></i><span><?=translate('academic')?></span>
                        </a>

                        <ul class="nav nav-children">
                            <?php
                            if(get_permission('classes', 'is_view') ||
                            get_permission('section', 'is_view') ||
                            get_permission('assign_class_teacher', 'is_view')) {
                            ?>
                            <!-- class -->
                            <li class="nav-parent <?php
                            if ($main_menu == 'classes' || $main_menu == 'sections' || $main_menu == 'class_teacher_allocation') echo 'nav-expanded nav-active'; ?>">
                                <a>
                                    <i class="fas fa-tasks" aria-hidden="true"></i>
                                    <span><?=translate('class') . " & ". translate('section')?></span>
                                </a>
                                <ul class="nav nav-children">
                                    <?php if(get_permission('classes', 'is_view') ||  get_permission('section', 'is_view')) { ?>
                                    <li class="<?php if ($sub_page == 'classes/index' ||
                                                            $sub_page == 'classes/edit' ||
                                                                $sub_page == 'sections/index' ||
                                                                    $sub_page == 'sections/edit') echo 'nav-active';?>">
                                        <a href="<?=get_permission('classes', 'is_view') ? base_url('classes') : base_url('sections'); ?>">
                                            <span><?=translate('control_classes')?></span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                    <?php if(get_permission('assign_class_teacher', 'is_view')) { ?>
                                    <li class="<?php if ($sub_page == 'classes/teacher_allocation') echo 'nav-active';?>">
                                        <a href="<?=base_url('classes/teacher_allocation')?>">
                                            <span><?=translate('assign_class_teacher')?></span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php } ?>
                            <?php
                            if(get_permission('subject', 'is_view') ||
                            get_permission('subject_class_assign', 'is_view') ||
                            get_permission('subject_teacher_assign', 'is_view')) {
                            ?>
                            <!-- subject -->
                            <li class="nav-parent <?php if ($main_menu == 'subject') echo 'nav-expanded';?>">
                                <a>
                                    <i class="fas fa-book-reader"></i><?=translate('subject')?>
                                </a>
                                <ul class="nav nav-children">
                                    <?php if(get_permission('subject', 'is_view')) { ?>
                                    <li class="<?php if ($sub_page == 'subject/index' || $sub_page == 'subject/edit') echo 'nav-active';?>">
                                        <a href="<?=base_url('subject/index')?>">
                                            <span><?=translate('subject')?></span>
                                        </a>
                                    </li>
                                    <?php } if(get_permission('subject_class_assign', 'is_view')) { ?>
                                    <li class="<?php if ($sub_page == 'subject/class_assign') echo 'nav-active';?>">
                                        <a href="<?=base_url('subject/class_assign')?>">
                                            <span><?=translate('class_assign')?></span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php } ?>
                            <?php if(get_permission('class_timetable', 'is_view')) { ?>
                            <li class="<?php if ($sub_page == 'timetable/viewclass' || $sub_page == 'timetable/update_classwise' || $sub_page == 'timetable/set_classwise') echo 'nav-active';?>">
                                <a href="<?=base_url('timetable/viewclass')?>">
                                    <span><i class="fas fa-dna" aria-hidden="true"></i><?=translate('class') . " " . translate('schedule')?></span>
                                </a>
                            </li>
                            <?php } ?>
                            <?php if(get_permission('teacher_timetable', 'is_view')) { ?>
                            <!-- teacher timetable view -->
                            <li class="<?php if ($sub_page == 'timetable/teacherview') echo 'nav-active';?>">
                                <a href="<?=base_url('timetable/teacherview')?>">
                                    <span><i class="fas fa-chalkboard-teacher" aria-hidden="true"></i> <?=translate('teacher') . " " . translate('schedule')?></span>
                                </a>
                            </li>
                            <?php } ?>
                            <?php if(get_permission('student_promotion', 'is_view')) { ?>
                            <!-- student promotion -->
                            <li class="<?php if ($sub_page == 'student_promotion/index') echo 'nav-active';?>">
                                <a href="<?=base_url('student_promotion')?>">
                                    <span><i class="fab fa-deviantart" aria-hidden="true"></i><?=translate('promotion')?></span>
                                </a>
                            </li>
                            <?php } ?>
                            <!-- ❖ E-Learning sub-group (Live Class, Homework, Attachments) -->
                            <?php
                            $hasElearning = (moduleIsEnabled('live_class') && get_permission('live_class', 'is_view'))
                                         || (moduleIsEnabled('attachments_book') && (get_permission('attachments', 'is_view') || get_permission('attachment_type', 'is_view')))
                                         || (moduleIsEnabled('homework') && (get_permission('homework', 'is_view') || get_permission('evaluation_report', 'is_view')));
                            if ($hasElearning): ?>
                            <li class="nav-parent <?php if ($main_menu == 'live_class' || $main_menu == 'attachments' || $main_menu == 'homework') echo 'nav-expanded nav-active'; ?>">
                                <a>
                                    <i class="fas fa-laptop-code"></i><span>E-Learning</span>
                                </a>
                                <ul class="nav nav-children">
                                    <?php if (moduleIsEnabled('live_class') && get_permission('live_class', 'is_view')): ?>
                                    <li class="nav-parent <?php if ($main_menu == 'live_class') echo 'nav-expanded nav-active'; ?>">
                                        <a><i class="icons icon-earphones-alt"></i><span><?=translate('live_class_rooms')?></span></a>
                                        <ul class="nav nav-children">
                                            <li class="<?php if ($sub_page == 'live_class/index') echo 'nav-active'; ?>">
                                                <a href="<?=base_url('live_class')?>"><span><i class="fas fa-caret-right"></i> <?=translate('live_class_rooms')?></span></a>
                                            </li>
                                            <li class="<?php if ($sub_page == 'live_class/reports') echo 'nav-active'; ?>">
                                                <a href="<?=base_url('live_class/reports')?>"><span><i class="fas fa-caret-right"></i> <?=translate(' live_class_reports')?></span></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <?php endif; ?>
                                    <?php if (moduleIsEnabled('homework') && (get_permission('homework', 'is_view') || get_permission('evaluation_report', 'is_view'))): ?>
                                    <li class="nav-parent <?php if ($main_menu == 'homework') echo 'nav-expanded nav-active'; ?>">
                                        <a><i class="icons icon-note"></i><span><?=translate('homework')?></span></a>
                                        <ul class="nav nav-children">
                                            <?php if (get_permission('homework', 'is_view')): ?>
                                            <li class="<?php if ($sub_page == 'homework/index' || $sub_page == 'homework/add' || $sub_page == 'homework/evaluate_list' || $sub_page == 'homework/edit') echo 'nav-active'; ?>">
                                                <a href="<?=base_url('homework')?>"><span><i class="fas fa-caret-right"></i><?=translate('homework')?></span></a>
                                            </li>
                                            <?php endif; if (get_permission('evaluation_report', 'is_view')): ?>
                                            <li class="<?php if ($sub_page == 'homework/report') echo 'nav-active'; ?>">
                                                <a href="<?=base_url('homework/report')?>"><span><i class="fas fa-caret-right"></i><?=translate('evaluation_report')?></span></a>
                                            </li>
                                            <?php endif; ?>
                                        </ul>
                                    </li>
                                    <?php endif; ?>
                                    <?php if (moduleIsEnabled('attachments_book') && (get_permission('attachments', 'is_view') || get_permission('attachment_type', 'is_view'))): ?>
                                    <li class="nav-parent <?php if ($main_menu == 'attachments') echo 'nav-expanded nav-active'; ?>">
                                        <a><i class="icons icon-cloud-upload"></i><span><?=translate('attachments_book')?></span></a>
                                        <ul class="nav nav-children">
                                            <?php if (get_permission('attachments', 'is_view')): ?>
                                            <li class="<?php if ($sub_page == 'attachments/index') echo 'nav-active'; ?>">
                                                <a href="<?=base_url('attachments')?>"><span><i class="fas fa-caret-right"></i><?=translate('upload_content')?></span></a>
                                            </li>
                                            <?php endif; if (get_permission('attachment_type', 'is_view')): ?>
                                            <li class="<?php if ($sub_page == 'attachments/type') echo 'nav-active'; ?>">
                                                <a href="<?=base_url('attachments/type')?>"><span><i class="fas fa-caret-right"></i><?=translate('attachment_type')?></span></a>
                                            </li>
                                            <?php endif; ?>
                                        </ul>
                                    </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <?php } ?>
                    <?php /* Live Class, Attachments Book, Homework moved into E-Learning under Academic — see Academic block below */ ?>
                    <?php
                    if(get_permission('exam', 'is_view') ||
                    get_permission('exam_term', 'is_view') ||
                    get_permission('mark_distribution', 'is_view') ||
                    get_permission('exam_hall', 'is_view') ||
                    get_permission('exam_timetable', 'is_view') ||
                    get_permission('exam_mark', 'is_view') ||
                    get_permission('generate_position', 'is_view') ||
                    get_permission('marksheet_template', 'is_view') ||
                    get_permission('exam_grade', 'is_view')) {
                    ?>
                    <!-- exam master -->
                    <li class="nav-parent <?php if ($main_menu == 'exam' || $main_menu == 'mark' || $main_menu == 'exam_timetable' || $main_menu == 'marksheet_template') echo 'nav-expanded nav-active';?>">
                        <a>
                            <i class="icons icon-book-open" aria-hidden="true"></i><span><?=translate('exam_master')?></span>
                        </a>
                        <ul class="nav nav-children">
                            <?php
                            if(get_permission('exam', 'is_view') ||
                            get_permission('exam_term', 'is_view') ||
                            get_permission('marksheet_template', 'is_view') ||
                            get_permission('mark_distribution', 'is_view') ||
                            get_permission('exam_hall', 'is_view')) {
                            ?>
                            <!-- exam -->
                            <li class="nav-parent <?php if ($main_menu == 'exam' || $main_menu == 'exam_term' || $main_menu == 'exam_hall' || $main_menu == 'marksheet_template') echo 'nav-expanded nav-active';?>">
                                <a>
                                    <i class="fas fa-flask"></i> <span><?=translate('exam')?></span>
                                </a>
                                <ul class="nav nav-children">
                                    <?php if (get_permission('exam_term', 'is_view')) {  ?>
                                    <li class="<?php if ($sub_page == 'exam/term') echo 'nav-active';?>">
                                        <a href="<?=base_url('exam/term')?>">
                                            <span><?=translate('exam_term')?></span>
                                        </a>
                                    </li>
                                    <?php } if (get_permission('exam_hall', 'is_view')) { ?>
                                    <li class="<?php if ($sub_page == 'exam/hall') echo 'nav-active';?>">
                                        <a href="<?=base_url('exam/hall')?>">
                                            <span><?=translate('exam_hall')?></span>
                                        </a>
                                    </li>
                                    <?php } if (get_permission('mark_distribution', 'is_view')) { ?>
                                    <li class="<?php if ($sub_page == 'exam/mark_distribution') echo 'nav-active';?>">
                                        <a href="<?=base_url('exam/mark_distribution')?>">
                                            <span><?=translate('distribution')?></span>
                                        </a>
                                    </li>
                                    <?php } if (get_permission('exam', 'is_view')) { ?>
                                    <li class="<?php if ($sub_page == 'exam/index') echo 'nav-active';?>">
                                        <a href="<?=base_url('exam')?>">
                                            <span><?=translate('exam_setup')?></span>
                                        </a>
                                    </li>
                                    <?php } if (get_permission('marksheet_template', 'is_view')) { ?>
                                    <li class="<?php if ($sub_page == 'marksheet_template/index') echo 'nav-active';?>">
                                        <a href="<?=base_url('marksheet_template/index')?>">
                                            <span><?=translate('marksheet') . " " . translate('template')?></span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php } ?>
                            <?php
                            if(get_permission('exam_timetable', 'is_view')) {
                            ?>
                            <!-- exam schedule -->
                            <li class="nav-parent <?php if ($main_menu == 'exam_timetable') echo 'nav-expanded nav-active';?>">
                                <a>
                                    <i class="fas fa-dna"></i> <span><?=translate('exam') . " " . translate('schedule')?></span>
                                </a>
                                <ul class="nav nav-children">
                                    <?php if(get_permission('exam_timetable', 'is_view')) { ?>
                                    <li class="<?php if ($sub_page == 'timetable/viewexam') echo 'nav-active';?>">
                                        <a href="<?=base_url('timetable/viewexam')?>">
                                            <span><?=translate('schedule')?></span>
                                        </a>
                                    </li>
                                    <?php } if(get_permission('exam_timetable', 'is_view')) { ?>
                                    <li class="<?php if ($sub_page == 'timetable/set_examwise') echo 'nav-active';?>">
                                        <a href="<?=base_url('timetable/set_examwise')?>">
                                            <span><?=translate('add') . " " . translate('schedule')?></span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php } ?>
                            <?php
                            if(get_permission('exam_mark', 'is_view') ||
                                get_permission('generate_position', 'is_view') ||
                                    get_permission('exam_grade', 'is_view')) {
                                        ?>
                            <!-- marks -->
                            <li class="nav-parent <?php if ($main_menu == 'mark') echo 'nav-expanded nav-active';?>">
                                <a>
                                    <i class="fas fa-marker"></i><span><?=translate('marks')?></span>
                                </a>
                                <ul class="nav nav-children">
                                    <?php if(get_permission('exam_mark', 'is_view')) { ?>
                                    <li class="<?php if ($sub_page == 'exam/marks_register') echo 'nav-active';?>">
                                        <a href="<?=base_url('exam/mark_entry')?>">
                                            <span><?=translate('mark_entries')?></span>
                                        </a>
                                    </li>
                                    <?php } if(get_permission('generate_position', 'is_view')) { ?>
                                    <li class="<?php if ($sub_page == 'exam/class_position') echo 'nav-active';?>">
                                        <a href="<?=base_url('exam/class_position')?>">
                                            <span><?=translate('generate_position')?></span>
                                        </a>
                                    </li>
                                    <?php } if(get_permission('exam_grade', 'is_view')) { ?>
                                    <li class="<?php if ($sub_page == 'exam/grade') echo 'nav-active';?>">
                                        <a href="<?=base_url('exam/grade')?>">
                                            <span><?=translate('grades_range')?></span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php } ?>

                    <!-- CBT (Computer-Based Test) - Standalone Top-Level Module -->
                    <?php if (moduleIsEnabled('online_exam') && (get_permission('online_exam', 'is_view') || get_permission('question_bank', 'is_view') || get_permission('exam_result', 'is_view') || get_permission('position_generate', 'is_view') || get_permission('question_group', 'is_view'))): ?>
                    <li class="nav-parent <?php if ($main_menu == 'onlineexam') echo 'nav-expanded nav-active'; ?>">
                        <a>
                            <i class="fas fa-desktop" aria-hidden="true"></i><span>CBT <small style="font-size:10px;opacity:.75">(Online Exam)</small></span>
                        </a>
                        <ul class="nav nav-children">
                            <?php if (get_permission('online_exam', 'is_view')): ?>
                            <li class="<?php if ($sub_page == 'onlineexam/index' || $sub_page == 'onlineexam/edit' || $sub_page == 'onlineexam/manage_question' || $sub_page == 'onlineexam/question_list') echo 'nav-active'; ?>">
                                <a href="<?=base_url('onlineexam')?>"><span><i class="fas fa-clipboard-list"></i> CBT Exams</span></a>
                            </li>
                            <?php endif; if (get_permission('question_bank', 'is_view')): ?>
                            <li class="<?php if ($sub_page == 'onlineexam/question' || $sub_page == 'onlineexam/question_add' || $sub_page == 'onlineexam/question_edit') echo 'nav-active'; ?>">
                                <a href="<?=base_url('onlineexam/question')?>"><span><i class="fas fa-question-circle"></i> <?=translate('question_bank')?></span></a>
                            </li>
                            <?php endif; if (get_permission('question_group', 'is_view')): ?>
                            <li class="<?php if ($sub_page == 'onlineexam/question_group') echo 'nav-active'; ?>">
                                <a href="<?=base_url('onlineexam/question_group')?>"><span><i class="fas fa-object-group"></i> <?=translate('question_group')?></span></a>
                            </li>
                            <?php endif; if (get_permission('position_generate', 'is_view')): ?>
                            <li class="<?php if ($sub_page == 'onlineexam/position_generate') echo 'nav-active'; ?>">
                                <a href="<?=base_url('onlineexam/position_generate')?>"><span><i class="fas fa-sort-numeric-up"></i> <?=translate('position') . ' ' . translate('generate')?></span></a>
                            </li>
                            <?php endif; if (get_permission('exam_result', 'is_view')): ?>
                            <li class="<?php if ($sub_page == 'onlineexam/result') echo 'nav-active'; ?>">
                                <a href="<?=base_url('onlineexam/result')?>"><span><i class="fas fa-chart-bar"></i> <?=translate('exam_result')?></span></a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <?php endif; ?>

                    <?php
                    if (moduleIsEnabled('hostel') || moduleIsEnabled('transport')) {
                    if(get_permission('hostel', 'is_view') ||
                    get_permission('hostel_category', 'is_view') ||
                    get_permission('hostel_room', 'is_view') ||
                    get_permission('hostel_allocation', 'is_view') ||
                    get_permission('transport_route', 'is_view') ||
                    get_permission('transport_vehicle', 'is_view') ||
                    get_permission('transport_stoppage', 'is_view') ||
                    get_permission('transport_assign', 'is_view') ||
                    get_permission('transport_fees_setup', 'is_view') ||
                    get_permission('transport_allocation', 'is_view')) {
                    ?>
                    <!-- supervision -->
                    <li class="nav-parent <?php if ($main_menu == 'hostels' || $main_menu == 'transport') echo 'nav-expanded nav-active';?>">
                        <a>
                            <i class="icons icon-feed" aria-hidden="true"></i><span><?=translate('supervision')?></span>
                        </a>
                        <ul class="nav nav-children">
                            <?php
                            if (moduleIsEnabled('hostel')) {
                                if(get_permission('hostel', 'is_view') ||
                                get_permission('hostel_category', 'is_view') ||
                                get_permission('hostel_room', 'is_view') ||
                                get_permission('hostel_allocation', 'is_view')) {
                                ?>
                            <!-- hostels -->
                            <li class="nav-parent <?php if ($main_menu == 'hostels') echo 'nav-expanded nav-active';?>">
                                <a>
                                    <i class="fas fa-store-alt"></i><span><?=translate('hostel')?></span>
                                </a>
                                <ul class="nav nav-children">
                                    <?php  if(get_permission('hostel', 'is_view')) { ?>
                                    <li class="<?php if ($sub_page == 'hostels/index' || $sub_page == 'hostels/edit') echo 'nav-active';?>">
                                        <a href="<?=base_url('hostels')?>">
                                            <span><?=translate('hostel_master')?></span>
                                        </a>
                                    </li>
                                    <?php } if(get_permission('hostel_room', 'is_view')) { ?>
                                    <li class="<?php if ($sub_page == 'hostels/room' || $sub_page == 'hostels/room_edit') echo 'nav-active';?>">
                                        <a href="<?=base_url('hostels/room')?>">
                                            <span><?=translate('hostel_room')?></span>
                                        </a>
                                    </li>
                                    <?php } if(get_permission('hostel_category', 'is_view')) { ?>
                                    <li class="<?php if ($sub_page == 'hostels/category') echo 'nav-active';?>">
                                        <a href="<?=base_url('hostels/category')?>">
                                            <span><?=translate('category')?></span>
                                        </a>
                                    </li>
                                    <?php } if(get_permission('hostel_allocation', 'is_view')) { ?>
                                    <li class="<?php if ($sub_page == 'hostels/allocation') echo 'nav-active';?>">
                                        <a href="<?=base_url('hostels/allocation_report')?>">
                                            <span><?=translate('allocation_report')?></span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php }} ?>
                            <?php
                            if (moduleIsEnabled('transport')) {
                                if(get_permission('transport_route', 'is_view') ||
                                get_permission('transport_vehicle', 'is_view') ||
                                get_permission('transport_stoppage', 'is_view') ||
                                get_permission('transport_assign', 'is_view') ||
                                get_permission('transport_fees_setup', 'is_view') ||
                                get_permission('transport_allocation', 'is_view')) {
                                ?>
                            <!-- transport -->
                            <li class="nav-parent <?php if ($main_menu == 'transport') echo 'nav-expanded nav-active';?>">
                                <a>
                                    <i class="fas fa-bus"></i><span><?=translate('transport')?></span>
                                </a>
                                <ul class="nav nav-children">
                                    <?php if(get_permission('transport_route', 'is_view')) { ?>
                                    <li class="<?php if ($sub_page == 'transport/route' || $sub_page == 'transport/route_edit') echo 'nav-active';?>">
                                        <a href="<?=base_url('transport/route')?>">
                                            <span><?=translate('route_master')?></span>
                                        </a>
                                    </li>
                                    <?php } if(get_permission('transport_vehicle', 'is_view')) { ?>
                                    <li class="<?php if ($sub_page == 'transport/vehicle' || $sub_page == 'transport/vehicle_edit') echo 'nav-active';?>">
                                        <a href="<?=base_url('transport/vehicle')?>">
                                            <span><?=translate('vehicle_master')?></span>
                                        </a>
                                    </li>
                                    <?php } if(get_permission('transport_stoppage', 'is_view')) { ?>
                                    <li class="<?php if ($sub_page == 'transport/stoppage' || $sub_page == 'transport/stoppage_edit') echo 'nav-active';?>">
                                        <a href="<?=base_url('transport/stoppage')?>">
                                            <span><?=translate('stoppage')?></span>
                                        </a>
                                    </li>
                                    <?php } if(get_permission('transport_assign', 'is_view')) { ?>
                                    <li class="<?php if ($sub_page == 'transport/vehicle_assign' || $sub_page == 'transport/vehicle_assign_edit') echo 'nav-active';?>">
                                        <a href="<?=base_url('transport/vehicle_assign')?>">
                                            <span><?=translate('assign_vehicle')?></span>
                                        </a>
                                    </li>
                                    <?php } if(get_permission('transport_fees_setup', 'is_view')) { ?>
                                    <li class="<?php if ($sub_page == 'transport/fees_setup' || $sub_page == 'transport/fees_setup_edit') echo 'nav-active';?>">
                                        <a href="<?=base_url('transport/fees_setup')?>">
                                            <span><?=translate('fees_setup')?></span>
                                        </a>
                                    </li>
                                    <?php } if(get_permission('transport_allocation', 'is_view')) { ?>
                                    <li class="<?php if ($sub_page == 'transport/allocation') echo 'nav-active';?>">
                                        <a href="<?=base_url('transport/report')?>">
                                            <span><?=translate('allocation_report')?></span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php }} ?>
                        </ul>
                    </li>
                    <?php }} ?>
                    <?php
                    if (moduleIsEnabled('attendance')) {
                        if(get_permission('student_attendance', 'is_add') ||
                        get_permission('employee_attendance', 'is_add') ||
                        get_permission('exam_attendance', 'is_add')) {
                        ?>

                    <!-- attendance control -->
                    <li class="nav-parent <?php if ($main_menu == 'attendance') echo 'nav-expanded nav-active';?>">
                        <a>
                            <i class="icons icon-chart"></i><span><?=translate('attendance')?></span>
                        </a>
                        <ul class="nav nav-children">
                            <?php if(get_permission('student_attendance', 'is_add')) { 
                                $getAttendanceType = $this->app_lib->getAttendanceType();
                                if ($getAttendanceType == 2 || $getAttendanceType == 0) {
                                ?>
                            <li class="<?php if ($sub_page == 'attendance/student_entries') echo 'nav-active';?>">
                                <a href="<?=base_url('attendance/student_entry')?>">
                                    <span><i class="fas fa-caret-right"></i><?=translate('student')?></span>
                                </a>
                            </li>
                            <?php } if ($getAttendanceType == 2 || $getAttendanceType == 1) { ?>
                            <li class="<?php if ($sub_page == 'attendance_period/index') echo 'nav-active';?>">
                                <a href="<?=base_url('attendance_period/index')?>">
                                    <span><i class="fas fa-caret-right"></i><?=translate('subject_wise')?></span>
                                </a>
                            </li>
                            <?php } } if(get_permission('employee_attendance', 'is_add')) { ?>
                            <li class="<?php if ($sub_page == 'attendance/employees_entries') echo 'nav-active';?>">
                                <a href="<?=base_url('attendance/employees_entry')?>">
                                    <span><i class="fas fa-caret-right"></i><?=translate('employee')?></span>
                                </a>
                            </li>
                            <?php } if(get_permission('exam_attendance', 'is_add')) { ?>
                            <li class="<?php if ($sub_page == 'attendance/exam_entries') echo 'nav-active';?>">
                                <a href="<?=base_url('attendance/exam_entry')?>">
                                    <span><i class="fas fa-caret-right"></i><?=translate('exam')?></span>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php } } ?>
                    <?php if ($this->app_lib->isExistingAddon('qrcode') && moduleIsEnabled('qr_code_attendance')) { 
                        if(get_permission('qr_code_student_attendance', 'is_add') ||
                            get_permission('qr_code_employee_attendance', 'is_add') ||
                                get_permission('qr_code_student_attendance_report', 'is_view') ||
                                get_permission('qr_code_employee_attendance_report', 'is_view') ) {
                            
                            include "qr_code_menu.php";

                         } } ?>
                    <?php
                    if (moduleIsEnabled('library')) {
                        if(get_permission('book', 'is_view') ||
                        get_permission('book_category', 'is_view') ||
                        get_permission('book_manage', 'is_view') ||
                        get_permission('book_request', 'is_view')) {
                    ?>
                    <!-- library -->
                    <li class="nav-parent <?php if ($main_menu == 'library') echo 'nav-expanded nav-active';?>">
                        <a>
                            <i class="icons icon-notebook"></i><span><?=translate('library')?></span>
                        </a>
                        <ul class="nav nav-children">
                            <?php if (get_permission('book', 'is_view')) {  ?>
                            <li class="<?php if ($sub_page == 'library/book') echo 'nav-active';?>">
                                <a href="<?=base_url('library/book')?>">
                                    <span><i class="fas fa-caret-right"></i><?=translate('books')?></span>
                                </a>
                            </li>
                            <?php } if (get_permission('book_category', 'is_view')) {  ?>
                            <li class="<?php if ($sub_page == 'library/category') echo 'nav-active';?>">
                                <a href="<?=base_url('library/category')?>">
                                    <span><i class="fas fa-caret-right"></i><?=translate('books_category')?></span>
                                </a>
                            </li>
                            <?php } if (get_permission('book_request', 'is_view')) {  ?>
                            <li class="<?php if ($sub_page == 'library/request') echo 'nav-active';?>">
                                <a href="<?=base_url('library/request')?>">
                                    <span><i class="fas fa-caret-right"></i><?=translate('my_issued_book')?></span>
                                </a>
                            </li>
                            <?php } if (get_permission('book_manage', 'is_view')) {  ?>
                            <li class="<?php if ($sub_page == 'library/book_manage') echo 'nav-active';?>">
                                <a href="<?=base_url('library/book_manage')?>">
                                    <span><i class="fas fa-caret-right"></i><?=translate('book_issue/return')?></span>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php } } ?>
                    <?php
                    if (moduleIsEnabled('events')) {
                        if(get_permission('event', 'is_view') ||
                        get_permission('event_type', 'is_view')) {
                        ?>
                    <!-- envant -->
                    <li class="nav-parent <?php if ($main_menu == 'event') echo 'nav-expanded nav-active';?>">
                        <a>
                            <i class="icons icon-speech"></i><span><?=translate('events')?></span>
                        </a>
                        <ul class="nav nav-children">
                            <?php if (get_permission('event_type', 'is_view')) { ?>
                            <li class="<?php if ($sub_page == 'event/types') echo 'nav-active';?>">
                                <a href="<?=base_url('event/types')?>">
                                    <span><i class="fas fa-caret-right"></i><?=translate('event_type')?></span>
                                </a>
                            </li>
                            <?php } if (get_permission('event', 'is_view')) {  ?>
                            <li class="<?php if ($sub_page == 'event/index') echo 'nav-active';?>">
                                <a href="<?=base_url('event')?>">
                                    <span><i class="fas fa-caret-right"></i><?=translate('events')?></span>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php }} ?>
                    <?php
                    if (moduleIsEnabled('bulk_sms_and_email')) {
                        if(get_permission('sendsmsmail', 'is_add') ||
                        get_permission('sendsmsmail_template', 'is_view') ||
                        get_permission('student_birthday_wishes', 'is_view') ||
                        get_permission('staff_birthday_wishes', 'is_view') ||
                        get_permission('sendsmsmail_reports', 'is_view')) {
                        ?>
                    <!-- SMS -->
                    <li class="nav-parent <?php if ($main_menu == 'sendsmsmail') echo 'nav-expanded nav-active';?>">
                        <a>
                            <i class="icons icon-bell"></i><span><?=translate('bulk_sms_and_email')?></span>
                        </a>
                        <ul class="nav nav-children">
                            <?php if (get_permission('sendsmsmail', 'is_add')) {  ?>
                            <li class="<?php if ($sub_page == 'sendsmsmail/sms' || $sub_page == 'sendsmsmail/email') echo 'nav-active';?>">
                                <a href="<?=base_url('sendsmsmail/sms')?>">
                                    <span><i class="fas fa-caret-right"></i><?=translate('send')?> Sms / Email</span>
                                </a>
                            </li>
                            <li class="<?php if ($sub_page == 'sendsmsmail/campaign_reports') echo 'nav-active';?>">
                                <a href="<?=base_url('sendsmsmail/campaign_reports')?>">
                                    <span><i class="fas fa-caret-right"></i>Sms / Email <?=translate('report')?></span>
                                </a>
                            </li>
                            <?php } if (get_permission('sendsmsmail_template', 'is_view')) {  ?>
                            <li class="<?php if ($sub_page == 'sendsmsmail/template_sms' || $sub_page == 'sendsmsmail/template_edit_sms') echo 'nav-active';?>">
                                <a href="<?=base_url('sendsmsmail/template/sms')?>">
                                    <span><i class="fas fa-caret-right"></i> <?=translate('sms') . " " . translate('template')?></span>
                                </a>
                            </li>
                            <li class="<?php if ($sub_page == 'sendsmsmail/template_email' || $sub_page == 'sendsmsmail/template_edit_email') echo 'nav-active';?>">
                                <a href="<?=base_url('sendsmsmail/template/email')?>">
                                    <span><i class="fas fa-caret-right"></i> <?=translate('email') . " " . translate('template')?></span>
                                </a>
                            </li>
                            <?php } if (get_permission('student_birthday_wishes', 'is_view')) {  ?>
                            <li class="<?php if ($sub_page == 'birthday/student') echo 'nav-active';?>">
                                <a href="<?=base_url('birthday/student')?>">
                                    <span><i class="fas fa-caret-right"></i> Student Birthday Wishes</span>
                                </a>
                            </li>
                            <?php } if (get_permission('staff_birthday_wishes', 'is_view')) {  ?>
                            <li class="<?php if ($sub_page == 'birthday/staff') echo 'nav-active';?>">
                                <a href="<?=base_url('birthday/staff')?>">
                                    <span><i class="fas fa-caret-right"></i> Staff Birthday Wishes</span>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php }} ?>
                    <?php
                    if (moduleIsEnabled('student_accounting')) {
                        if(get_permission('fees_type', 'is_view') ||
                        get_permission('fees_group', 'is_view') ||
                        get_permission('fees_fine_setup', 'is_view') ||
                        get_permission('fees_allocation', 'is_view') ||
                        get_permission('invoice', 'is_view') ||
                        get_permission('due_invoice', 'is_view') ||
                        get_permission('offline_payments', 'is_view') ||
                        get_permission('offline_payments_type', 'is_view') ||
                        get_permission('fees_reminder', 'is_view')) {
                            $getOfflinePaymentsTotal = $this->application_model->getOfflinePaymentsTotal();
                        ?>
                    <!-- student accounting -->
                    <li class="nav-parent <?php if ($main_menu == 'fees' || $main_menu == 'offline_payments') echo 'nav-expanded nav-active';?>">
                        <a>
                            <i class="icons icon-calculator"></i><span><?=translate('student_accounting') .$getOfflinePaymentsTotal; ?></span>
                        </a>
                        <ul class="nav nav-children">

                            <?php if(get_permission('offline_payments', 'is_view') || get_permission('offline_payments_type', 'is_view')) { ?>
                            <li class="nav-parent <?php if ($main_menu == 'offline_payments') echo 'nav-expanded nav-active';?>">
                                <a>
                                    <i class="fas fa-store-alt"></i><span><?=translate('offline_payments')?> <?php echo $getOfflinePaymentsTotal ?></span>
                                </a>
                                <ul class="nav nav-children">
                                    <?php  if(get_permission('offline_payments_type', 'is_view')) { ?>
                                    <li class="<?php if ($sub_page == 'offline_payments/type' || $sub_page == 'offline_payments/type_edit') echo 'nav-active';?>">
                                        <a href="<?=base_url('offline_payments/type')?>">
                                            <span><?=translate('payments') . " " . translate('type')?></span>
                                        </a>
                                    </li>
                                    <?php } if(get_permission('offline_payments', 'is_view')) { ?>
                                    <li class="<?php if ($sub_page == 'offline_payments/history') echo 'nav-active';?>">
                                        <a href="<?=base_url('offline_payments/payments')?>">
                                            <span><?=translate(' offline_payments') . $getOfflinePaymentsTotal?></span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php } if(get_permission('fees_type', 'is_view')) { ?>
                            <li class="<?php if ($sub_page == 'fees/type') echo 'nav-active';?>">
                                <a href="<?=base_url('fees/type')?>"><span><i class="fas fa-caret-right"></i><?=translate('fees_type')?></span></a>
                            </li>
                            <?php } if(get_permission('fees_group', 'is_view')) { ?>
                            <li class="<?php if ($sub_page == 'fees/group') echo 'nav-active';?>">
                                <a href="<?=base_url('fees/group')?>"><span><i class="fas fa-caret-right"></i><?=translate('fees_group')?></span></a>
                            </li>
                            <?php } if(get_permission('fees_fine_setup', 'is_view')) { ?>
                            <li class="<?php if ($sub_page == 'fees/fine_setup') echo 'nav-active';?>">
                                <a href="<?=base_url('fees/fine_setup')?>"><span><i class="fas fa-caret-right"></i><?=translate('fine_setup')?></span></a>
                            </li>
                            <?php } if(get_permission('fees_allocation', 'is_view')) { ?>
                            <li class="<?php if ($sub_page == 'fees/allocation') echo 'nav-active';?>">
                                <a href="<?=base_url('fees/allocation')?>"><span><i class="fas fa-caret-right"></i><?=translate('fees_allocation')?></span></a>
                            </li>
                            <?php } if(get_permission('invoice', 'is_view')) { ?>
                            <li class="<?php if ($sub_page == 'fees/invoice_list' || $sub_page == 'fees/collect') echo 'nav-active';?>">
                                <a href="<?=base_url('fees/invoice_list')?>"><span><i class="fas fa-caret-right"></i><?=translate('payments_history')?></span></a>
                            </li>
                            <?php } if(get_permission('due_invoice', 'is_view')) { ?>
                            <li class="<?php if ($sub_page == 'fees/due_invoice') echo 'nav-active';?>">
                                <a href="<?=base_url('fees/due_invoice')?>"><span><i class="fas fa-caret-right"></i><?=translate('due_fees_invoice')?></span></a>
                            </li>
                            <?php } if(get_permission('fees_reminder', 'is_view')) { ?>
                            <li class="<?php if ($sub_page == 'fees/reminder') echo 'nav-active';?>">
                                <a href="<?=base_url('fees/reminder')?>"><span><i class="fas fa-caret-right"></i><?=translate('fees_reminder')?></span></a>
                            </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php }} ?>
                    <?php
                    if (moduleIsEnabled('office_accounting')) {
                        if(get_permission('account', 'is_view') ||
                        get_permission('voucher_head', 'is_view') ||
                        get_permission('deposit', 'is_view') ||
                        get_permission('expense', 'is_view') ||
                        get_permission('all_transactions', 'is_view')) {
                        ?>
                    <!-- office accounting -->
                    <li class="nav-parent <?php if ($main_menu == 'accounting') echo 'nav-expanded nav-active';?>">
                        <a>
                            <i class="icon-credit-card icons"></i><span><?=translate('office_accounting')?></span>
                        </a>
                        <ul class="nav nav-children">
                            <?php if(get_permission('account', 'is_view')){ ?>
                                <li class="<?php if ($sub_page == 'accounting/index' || $sub_page == 'accounting/edit') echo 'nav-active'; ?>">
                                    <a href="<?php echo base_url('accounting'); ?>">
                                        <span><i class="fas fa-caret-right" aria-hidden="true"></i><?php echo translate('account'); ?></span>
                                    </a>
                                </li>
                            <?php } if(get_permission('deposit', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'accounting/voucher_deposit' || $sub_page == 'accounting/voucher_deposit_edit') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('accounting/voucher_deposit'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?php echo translate('new_deposit'); ?></span>
                                </a>
                            </li>
                            <?php } if(get_permission('expense', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'accounting/voucher_expense' || $sub_page == 'accounting/voucher_expense_edit') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('accounting/voucher_expense'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?php echo translate('new_expense'); ?></span>
                                </a>
                            </li>
                            <?php } if(get_permission('all_transactions', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'accounting/all_transactions') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('accounting/all_transactions'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?php echo translate('all_transactions'); ?></span>
                                </a>
                            </li>
                            <?php } if(get_permission('voucher_head', 'is_view') || get_permission('voucher_head', 'is_add')){ ?>
                            <li class="<?php if ($sub_page == 'accounting/voucher_head') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('accounting/voucher_head'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?php echo translate('voucher') . " " . translate('head'); ?></span>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php }} ?>
                    <!-- message -->
                    <li class="<?php if ($main_menu == 'message') echo 'nav-active';?>">
                        <a href="<?=base_url('communication/mailbox/inbox')?>">
                            <i class="icons icon-envelope-open"></i><span><?=translate('message')?></span>
                        </a>
                    </li>

                    <?php 
                    $attendance_report = false;
                    if (get_permission('student_attendance_report', 'is_view') ||
                    get_permission('employee_attendance_report', 'is_view') ||
                    get_permission('exam_attendance_report', 'is_view')) {
                        $attendance_report = true;
                    }

                    if(get_permission('fees_reports', 'is_view') ||
                    get_permission('student', 'is_view') ||
                    get_permission('accounting_reports', 'is_view') ||
                    get_permission('inventory_report', 'is_view') ||
                    get_permission('salary_summary_report', 'is_view') ||
                    get_permission('leave_reports', 'is_view') ||
                    ($attendance_report == true) ||
                    get_permission('report_card', 'is_view') ||
                    get_permission('progress_reports', 'is_view') ||
                    get_permission('tabulation_sheet', 'is_view')) {
                    ?>
                    <!-- reports -->
                    <li class="nav-parent <?php if ($main_menu == 'accounting_repots' ||
                                                        $main_menu == 'student_repots' ||
                                                            $main_menu == 'fees_repots' ||
                                                                $main_menu == 'attendance_report' ||
                                                                    $main_menu == 'payroll_reports' ||
                                                                        $main_menu == 'leave_reports' ||
                                                                        $main_menu == 'inventory_report' ||
                                                                            $main_menu == 'exam_reports' ||
                                                                            $main_menu == 'nemis') echo 'nav-expanded nav-active';?>">
                        <a>
                            <i class="icons icon-pie-chart icons"></i><span><?=translate('reports')?></span>
                        </a>
                        <ul class="nav nav-children">
                            <?php if (get_permission('student', 'is_view')) { ?>
                            <li class="nav-parent <?php if ($main_menu == 'student_repots') echo 'nav-expanded nav-active'; ?>">
                                <a><i class="fas fa-print"></i><span><?php echo translate('student') . " " . translate('reports'); ?></span></a>
                                <ul class="nav nav-children">
                                    <li class="<?php if ($sub_page == 'student/login_credential_reports') echo 'nav-active';?>">
                                        <a href="<?=base_url('student/login_credential_reports')?>"><?=translate('login_credential')?></a>
                                    </li>
                                    <li class="<?php if ($sub_page == 'student/admission_reports') echo 'nav-active';?>">
                                        <a href="<?=base_url('student/admission_reports')?>"><?=translate('admission_report')?></a>
                                    </li>
                                    <li class="<?php if ($sub_page == 'student/classsection_reports') echo 'nav-active';?>">
                                        <a href="<?=base_url('student/classsection_reports')?>"><?=translate('class_&_section_report')?></a>
                                    </li>
                                    <li class="<?php if ($sub_page == 'student/sibling_report') echo 'nav-active';?>">
                                        <a href="<?=base_url('student/sibling_report')?>"><?=translate('sibling_report')?></a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php 
                        if (moduleIsEnabled('student_accounting')) {
                            if(get_permission('fees_reports', 'is_view')) { ?>
                            <li class="nav-parent <?php if ($main_menu == 'fees_repots') echo 'nav-expanded nav-active'; ?>">
                                <a><i class="fas fa-print"></i><span><?php echo translate('fees_reports'); ?></span></a>
                                <ul class="nav nav-children">
                                    <li class="<?php if ($sub_page == 'fees/student_fees_report') echo 'nav-active';?>">
                                        <a href="<?=base_url('fees/student_fees_report')?>"><?=translate('fees_report')?></a>
                                    </li>
                                    <li class="<?php if ($sub_page == 'fees/payment_history') echo 'nav-active';?>">
                                        <a href="<?=base_url('fees/payment_history')?>"><?=translate('receipts_report')?></a>
                                    </li>
                                    <li class="<?php if ($sub_page == 'fees/due_report') echo 'nav-active';?>">
                                        <a href="<?=base_url('fees/due_report')?>"><?=translate('due_fees_report')?></a>
                                    </li>
                                    <li class="<?php if ($sub_page == 'fees/fine_report') echo 'nav-active';?>">
                                        <a href="<?=base_url('fees/fine_report')?>"><?=translate('fine_report')?></a>
                                    </li>
                                </ul>
                            </li>
                        <?php }} ?>
                        <?php 
                        if (moduleIsEnabled('office_accounting')) {
                            if(get_permission('accounting_reports', 'is_view')){ ?>
                            <li class="nav-parent <?php if ($main_menu == 'accounting_repots') echo 'nav-expanded nav-active'; ?>">
                                <a><i class="fas fa-print"></i><span><?php echo translate('financial_reports'); ?></span></a>
                                <ul class="nav nav-children">
                                    <li class="<?php if ($sub_page == 'accounting/account_statement') echo 'nav-active'; ?>">
                                        <a href="<?php echo base_url('accounting/account_statement'); ?>"><?php echo translate('account') . " " . translate('statement'); ?></a>
                                    </li>
                                    <li class="<?php if ($sub_page == 'accounting/income_repots') echo 'nav-active'; ?>">
                                        <a href="<?php echo base_url('accounting/income_repots'); ?>"><?php echo translate('income') . " " . translate('repots'); ?></a>
                                    </li>
                                    <li class="<?php if ($sub_page == 'accounting/expense_repots') echo 'nav-active'; ?>">
                                        <a href="<?php echo base_url('accounting/expense_repots'); ?>"> <?php echo translate('expense') . " " . translate('repots'); ?></a>
                                    </li>
                                    <li class="<?php if ($sub_page == 'accounting/transitions_repots') echo 'nav-active'; ?>">
                                        <a href="<?php echo base_url('accounting/transitions_repots'); ?>"> <?php echo translate('transitions') . " " . translate('reports'); ?></a>
                                    </li>
                                    <li class="<?php if ($sub_page == 'accounting/balance_sheet') echo 'nav-active'; ?>">
                                        <a href="<?php echo base_url('accounting/balance_sheet'); ?>"><?php echo translate('balance') . " " . translate('sheet'); ?></a>
                                    </li>
                                    <li class="<?php if ($sub_page == 'accounting/income_vs_expense') echo 'nav-active'; ?>">
                                        <a href="<?php echo base_url('accounting/incomevsexpense'); ?>"> <?php echo translate('income_vs_expense'); ?></a>
                                    </li>

                                </ul>
                            </li>
                        <?php }} ?>
                        <?php 
                        if (moduleIsEnabled('attendance')) {
                            if($attendance_report == true) { ?>
                            <li class="nav-parent <?php if ($main_menu == 'attendance_report') echo 'nav-expanded nav-active'; ?>">
                                <a><i class="fas fa-print"></i><span><?php echo translate('attendance_reports'); ?></span></a>
                                <ul class="nav nav-children">
                                    <?php if(get_permission('student_attendance_report', 'is_view')) { 
                                        if ($getAttendanceType == 2 || $getAttendanceType == 0) {
                                        ?>
                                    <li class="<?php if ($sub_page == 'attendance/student_report') echo 'nav-active';?>">
                                        <a href="<?=base_url('attendance/studentwise_report')?>">
                                            <?=translate('student') . ' ' . translate('reports')?>
                                        </a>
                                    </li>
                                    <li class="<?php if ($sub_page == 'attendance/student_classreport') echo 'nav-active';?>">
                                        <a href="<?=base_url('attendance/student_classreport')?>">
                                            <?=translate('student') . ' ' . translate('daily_reports')?>
                                        </a>
                                    </li>
                                    <li class="<?php if ($sub_page == 'attendance/studentwise_overview') echo 'nav-active';?>">
                                        <a href="<?=base_url('attendance/studentwise_overview')?>">
                                            <?=translate('student') . ' ' . translate('overview_reports')?>
                                        </a>
                                    </li>
                                <?php } if ($getAttendanceType == 2 || $getAttendanceType == 1) { ?>
                                    <li class="<?php if ($sub_page == 'attendance_period/reports') echo 'nav-active';?>">
                                        <a href="<?=base_url('attendance_period/reports')?>">
                                            <?=translate('subject_wise_reports') ?>
                                        </a>
                                    </li>
                                    <li class="<?php if ($sub_page == 'attendance_period/reportsbydate') echo 'nav-active';?>">
                                        <a href="<?=base_url('attendance_period/reportsbydate')?>">
                                            <?=translate('subject_wise_by') . ' ' . translate('day')?>
                                        </a>
                                    </li>
                                    <li class="<?php if ($sub_page == 'attendance_period/reportbymonth') echo 'nav-active';?>">
                                        <a href="<?=base_url('attendance_period/reportbymonth')?>">
                                            <?=translate('subject_wise_by') . ' ' . translate('month')?>
                                        </a>
                                    </li>
                                <?php } ?>
                                    <?php } if(get_permission('employee_attendance_report', 'is_view')) { ?>
                                    <li class="<?php if ($sub_page == 'attendance/employees_report') echo 'nav-active';?>">
                                        <a href="<?=base_url('attendance/employeewise_report')?>">
                                            <?=translate('employee') . ' ' . translate('reports')?>
                                        </a>
                                    </li>
                                    <?php } if(get_permission('exam_attendance_report', 'is_view')) { ?>
                                    <li class="<?php if ($sub_page == 'attendance/exam_report') echo 'nav-active';?>">
                                        <a href="<?=base_url('attendance/examwise_report')?>">
                                            <?=translate('exam') . ' ' . translate('reports')?>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } } ?>
                        <?php 
                        if (moduleIsEnabled('human_resource')) {
                            if(get_permission('salary_summary_report', 'is_view') || get_permission('leave_reports', 'is_view')){ ?>
                            <li class="nav-parent <?php if ($main_menu == 'payroll_reports' || $main_menu == 'leave_reports') echo 'nav-expanded nav-active'; ?>">
                                <a><i class="fas fa-print"></i><span><?php echo translate('hrm'); ?></span></a>
                                <ul class="nav nav-children">
                                    <?php if(get_permission('salary_summary_report', 'is_view')){ ?>
                                    <li class="<?php if ($sub_page == 'payroll/salary_statement') echo 'nav-active';?>">
                                        <a href="<?=base_url('payroll/salary_statement')?>">
                                            <span><?=translate('payroll_summary')?></span>
                                        </a>
                                    </li>
                                    <?php } if (get_permission('leave_reports', 'is_view')) { ?>
                                    <li class="<?php if ($sub_page == 'leave/reports') echo 'nav-active';?>">
                                        <a href="<?=base_url('leave/reports')?>">
                                            <span><?=translate('leave') . " " . translate('reports')?></span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php }} ?>
                        <?php if(get_permission('report_card', 'is_view') || get_permission('tabulation_sheet', 'is_view') || get_permission('progress_reports', 'is_view')) { ?>
                            <li class="nav-parent <?php if ($main_menu == 'exam_reports') echo 'nav-expanded nav-active'; ?>">
                                <a><i class="fas fa-print"></i><span><?php echo translate('examination'); ?></span></a>
                                <ul class="nav nav-children">
                                    <?php if(get_permission('report_card', 'is_view')) { ?>
                                    <li class="<?php if ($sub_page == 'exam/marksheet') echo 'nav-active';?>">
                                        <a href="<?=base_url('exam/marksheet')?>">
                                            <span><?=translate('report_card')?></span>
                                        </a>
                                    </li>
                                    <?php } if(get_permission('tabulation_sheet', 'is_view')) { ?>
                                    <li class="<?php if ($sub_page == 'exam/tabulation_sheet') echo 'nav-active';?>">
                                        <a href="<?=base_url('exam/tabulation_sheet')?>">
                                            <span><?=translate('tabulation_sheet')?></span>
                                        </a>
                                    </li>
                                    <?php } if(get_permission('progress_reports', 'is_view')) { ?>
                                    <li class="<?php if ($sub_page == 'exam_progress/marksheet') echo 'nav-active';?>">
                                        <a href="<?=base_url('exam_progress/marksheet')?>">
                                            <span><?=translate('progress') . " " . translate('reports')?></span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>

                        <?php if(get_permission('inventory_report', 'is_view')){  ?>
                            <!-- Reports -->
                            <li class="nav-parent <?php if ($main_menu == 'inventory_report') echo 'nav-expanded'; ?>">
                                <a><i class="fas fa-print" aria-hidden="true"></i><?php echo translate('inventory'); ?></a>
                                <ul class="nav nav-children">
                                    <li class="<?php if ($sub_page == 'inventory/stockreport') echo 'nav-active'; ?>">
                                        <a href="<?php echo base_url('inventory/stockreport'); ?>">
                                            <?php echo translate('stock') . " " . translate('report'); ?>
                                        </a>
                                    </li>
                                    <li class="<?php if ($sub_page == 'inventory/purchase_report') echo 'nav-active'; ?>">
                                        <a href="<?php echo base_url('inventory/purchase_report'); ?>">
                                            <?php echo translate('purchase') . " " . translate('report'); ?>
                                        </a>
                                    </li>
                                    <li class="<?php if ($sub_page == 'inventory/sales_report') echo 'nav-active'; ?>">
                                        <a href="<?php echo base_url('inventory/sales_report'); ?>">
                                            <?php echo translate('sales') . " " . translate('report'); ?>
                                        </a>
                                    </li>
                                    <li class="<?php if ($sub_page == 'inventory/issues_report') echo 'nav-active'; ?>">
                                        <a href="<?php echo base_url('inventory/issues_report'); ?>">
                                            <?php echo translate('issues') . " " . translate('report'); ?>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>

                            <!-- 🏗 NEMIS Reports (moved from top-level) -->
                            <?php if (is_superadmin_loggedin() || is_state_executive_loggedin() || is_admin_loggedin()): ?>
                            <li class="nav-parent <?php if ($main_menu == 'nemis') echo 'nav-expanded nav-active'; ?>">
                                <a><i class="fas fa-landmark"></i><span>NEMIS Reports</span></a>
                                <ul class="nav nav-children">
                                    <li class="<?php if ($sub_page == 'nemis/index') echo 'nav-active'; ?>">
                                        <a href="<?=base_url('nemis')?>"><span><i class="fas fa-caret-right"></i> Overview</span></a>
                                    </li>
                                    <li class="<?php if ($sub_page == 'nemis/waec_candidates') echo 'nav-active'; ?>">
                                        <a href="<?=base_url('nemis/waec_candidates')?>"><span><i class="fas fa-caret-right"></i> WAEC / BECE Candidates</span></a>
                                    </li>
                                    <li class="<?php if ($sub_page == 'nemis/asc_report') echo 'nav-active'; ?>">
                                        <a href="<?=base_url('nemis/asc_report')?>"><span><i class="fas fa-caret-right"></i> ASC Report</span></a>
                                    </li>
                                </ul>
                            </li>
                            <?php endif; ?>

                        </ul>
                    </li>
                    <?php } ?>

                    <?php if (moduleIsEnabled('alumni')) { 
                        if (get_permission('manage_alumni', 'is_view') ||
                            get_permission('alumni_events', 'is_view')) {
                        ?>
                    <!-- alumni -->
                    <li class="nav-parent <?php if ($main_menu == 'alumni') echo 'nav-expanded nav-active';?>">
                        <a>
                            <i class="fa-solid fa-person-chalkboard"></i><span><?=translate('alumni')?></span>
                        </a>
                        <ul class="nav nav-children">
                            <?php if(get_permission('manage_alumni', 'is_view')){ ?>
                                <li class="<?php if ($sub_page == 'alumni/index') echo 'nav-active'; ?>">
                                    <a href="<?php echo base_url('alumni/index'); ?>">
                                        <span><i class="fas fa-caret-right" aria-hidden="true"></i><?php echo translate('manage_alumni'); ?></span>
                                    </a>
                                </li>
                            <?php } if(get_permission('alumni_events', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'alumni/events') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('alumni/event'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?php echo translate('events'); ?></span>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php } } ?>
                    <!-- addon manager -->
                    <?php 
                    if (false && is_superadmin_loggedin()) { // Hidden per request ?>
                    <li class="<?php if ($main_menu == 'addon') echo 'nav-active';?>">
                        <a href="<?=base_url('addons/manage')?>">
                            <i class="icon-puzzle icons"></i><span><?=translate('addon_manager')?></span>
                        </a>
                    </li>
                    <?php } ?>

                    <?php
                    $schoolSettings = false;
                    if (get_permission('school_settings', 'is_view') ||
                    get_permission('live_class_config', 'is_view') ||
                    get_permission('payment_settings', 'is_view') ||
                    get_permission('sms_settings', 'is_view') ||
                    get_permission('email_settings', 'is_view') ||
                    get_permission('accounting_links', 'is_view')) {
                        $schoolSettings = true;
                    }
                    if (get_permission('global_settings', 'is_view') ||
                    ($schoolSettings == true) ||
                    get_permission('translations', 'is_view') ||
                    get_permission('cron_job', 'is_view') ||
                    get_permission('system_update', 'is_add') ||
                    get_permission('custom_field', 'is_view') ||
                    get_permission('backup', 'is_view')) {
                    ?>
                    <!-- setting -->
                    <li class="nav-parent <?php if ($main_menu == 'settings' || $main_menu == 'school_m') echo 'nav-expanded nav-active';?>">
                        <a>
                            <i class="icons icon-briefcase"></i><span><?=translate('settings')?></span>
                        </a>
                        <ul class="nav nav-children">
                            <?php if(get_permission('global_settings', 'is_view')){ ?>
                            <li class="<?php if($sub_page == 'settings/universal') echo 'nav-active';?>">
                                <a href="<?=base_url('settings/universal')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?=translate('global_settings')?></span>
                                </a>
                            </li>
                            <?php } if($schoolSettings == true){ ?>
                            <li class="<?php if($main_menu == 'school_m') echo 'nav-active';?>">
                                <a href="<?=base_url('school_settings')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?=translate('school_settings')?></span>
                                </a>
                            </li>
                            <?php } if (is_superadmin_loggedin()) { ?>
                            <li class="<?php if ($sub_page == 'role/index' || $sub_page == 'role/permission') echo 'nav-active';?>">
                                <a href="<?=base_url('role')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?=translate('role_permission')?></span>
                                </a>
                            </li>
                            <?php } if (is_superadmin_loggedin()) { ?>
                            <li class="<?php if ($sub_page == 'sessions/index') echo 'nav-active';?>">
                                <a href="<?=base_url('sessions')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?=translate('session_settings')?></span>
                                </a>
                            </li>
                            <?php } if(get_permission('translations', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'language/index') echo 'nav-active';?>">
                                <a href="<?=base_url('translations')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?=translate('translations')?></span>
                                </a>
                            </li>
                            <?php } if(get_permission('cron_job', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'cron_api/index') echo 'nav-active';?>">
                                <a href="<?=base_url('cron_api')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?=translate('cron_job')?></span>
                                </a>
                            </li>
                            <?php } if(is_superadmin_loggedin()){ ?>
                            <li class="<?php if ($sub_page == 'modules/index') echo 'nav-active';?>">
                                <a href="<?=base_url('modules')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?=translate('modules')?></span>
                                </a>
                            </li>
                            <?php } if(get_permission('system_student_field', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'system_student_field/index') echo 'nav-active';?>">
                                <a href="<?=base_url('system_student_field')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?=translate('system_student_field')?></span>
                                </a>
                            </li>
                            <?php } if(get_permission('custom_field', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'custom_field/index') echo 'nav-active';?>">
                                <a href="<?=base_url('custom_field')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?=translate('custom_field')?></span>
                                </a>
                            </li>
                            <?php } if(get_permission('backup', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'database_backup/index') echo 'nav-active';?>">
                                <a href="<?=base_url('backup')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?=translate('database_backup')?></span>
                                </a>
                            </li>
                            <?php } if(false){ // Hidden requested by user ?>
                            <li class="<?php if ($sub_page == 'system_update/index') echo 'nav-active';?>">
                                <a href="<?=base_url('system_update')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?=translate('system_update')?></span>
                                </a>
                            </li>
                            <?php } if(get_permission('user_login_log', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'user_login_log/index') echo 'nav-active';?>">
                                <a href="<?=base_url('user_login_log/index')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i><?=translate('user_login_log')?></span>
                                </a>
                            </li>
                            <?php } ?>

                        </ul>
                    </li>
                    <?php } ?>
                </ul>
            </nav>
        </div>
        <script>
            // maintain scroll position
            if (typeof localStorage !== 'undefined') {
                if (localStorage.getItem('sidebar-left-position') !== null) {
                    var initialPosition = localStorage.getItem('sidebar-left-position'),
                        sidebarLeft = document.querySelector('#sidebar-left .nano-content');
                    sidebarLeft.scrollTop = initialPosition;
                }
            }
        </script>
    </div>
</aside>
<!-- end sidebar -->