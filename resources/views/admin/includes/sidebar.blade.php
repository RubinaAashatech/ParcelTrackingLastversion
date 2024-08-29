
<nav class="navbar navbar-light navbar-vertical navbar-expand-xl">
    <script>
        var navbarStyle = localStorage.getItem("navbarStyle");
        if (navbarStyle && navbarStyle !== 'transparent') {
            document.querySelector('.navbar-vertical').classList.add(navbar-${navbarStyle});
        }
    </script>
    <div class="d-flex align-items-center">
        <div class="toggle-icon-wrapper">
            <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-bs-toggle="tooltip"
                data-bs-placement="left" aria-label="Toggle Navigation" data-bs-original-title="Toggle Navigation">
                <span class="navbar-toggle-icon"><span class="toggle-line"></span></span>
            </button>
        </div>
        <a class="navbar-brand" href="#">
            <div class="d-flex align-items-center py-3">
                <img class="me-2" src="{{ asset('adminassets/assets/img/icons/spot-illustrations/falcon.png') }}"
                    alt="" width="40">
                <span class="font-sans-serif">Admin</span>
            </div>
        </a>
    </div>
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
        <div class="navbar-vertical-content scrollbar">
            <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
                <li class="nav-item">
                    <a class="" href="#dashboard" role="button" data-bs-toggle="collapse"
                        aria-expanded="true" aria-controls="dashboard">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon">
                                <svg class="svg-inline--fa fa-chart-pie fa-w-17" aria-hidden="true" focusable="false"
                                    data-prefix="fas" data-icon="chart-pie" role="img"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 544 512" data-fa-i2svg="">
                                    <path fill="currentColor"
                                        d="M527.79 288H290.5l158.03 158.03c6.04 6.04 15.98 6.53 22.19.68 38.7-36.46 65.32-85.61 73.13-140.86 1.34-9.46-6.51-17.85-16.06-17.85zm-15.83-64.8C503.72 103.74 408.26 8.28 288.8.04 279.68-.59 272 7.1 272 16.24V240h223.77c9.14 0 16.82-7.68 16.19-16.8zM224 288V50.71c0-9.55-8.39-17.4-17.84-16.06C86.99 51.49-4.1 155.6.14 280.37 4.5 408.51 114.83 513.59 243.03 511.98c50.4-.63 96.97-16.87 135.26-44.03 7.9-5.6 8.42-17.23 1.57-24.08L224 288z">
                                    </path>
                                </svg>
                                <a href="#"><span class="nav-link-text ps-1">Dashboard</span></a>
                            </span>
                        </div>
                    </a>
                </li>

                {{-- Beginning of Site Settings --}}
               {{-- @hasanyrole('superadmin')  --}}

               <li class="nav-item">
                <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                    <div class="col-auto navbar-vertical-label">Customer</div>
                    <div class="col ps-0">
                        <hr class="mb-0 navbar-vertical-divider">
                    </div>
                </div>
                <li class="nav-item">
                    <a class="{{ Request::segment(2) == 'contact-details' ? '' : 'collapsed' }}"
                        href="{{route('api.customers.index')}}" role="button" data-bs-toggle="collapse"
                        aria-expanded="{{ Request::segment(2) == 'contact-details' ? 'true' : 'false' }}"
                        aria-controls="dashboard18">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><i class="fas fa-cog"></i></span>
                            <a href="{{route('api.customers.index')}}">
                            <span class="nav-link-text ps-1">Customer</span></a>
                        </div>
                    </a>


                    <li class="nav-item">
                        <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                            <div class="col-auto navbar-vertical-label">Receiver</div>
                            <div class="col ps-0">
                                <hr class="mb-0 navbar-vertical-divider">
                            </div>
                        </div>
                    <li class="nav-item">
                        <a class=" {{ Request::segment(2) == 'site-settings' ? '' : 'collapsed' }}"
                            href="{{ route('api.receivers.index') }}" role="button" data-bs-toggle="collapse"
                            aria-expanded="{{ Request::segment(2) == 'site-settings' ? 'true' : 'false' }}"
                            aria-controls="dashboard6">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon"><i class="fas fa-list"></i></span>
                                <a href="{{ route('api.receivers.index') }}">
                                <span class="nav-link-text ps-1">Receiver</span></a>
                            </div>
                        </a>

                        <ul class="nav collapse {{ Request::segment(2) == 'site-settings' ? 'show' : '' }}" id="dashboard6">

                            {{-- @can('list_site_settings')
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::segment(2) == 'site-settings' ? 'active' : '' }}"
                                        href="{{ route('category.index') }}">
                                        <div class="d-flex align-items-center">
                                            <i class="fa fa-angle-double-right"></i> Category
                                        </div>
                                    </a>
                                </li>
                            @endcan --}}
                            {{-- Insert Favicon Menu Item here --}}
                            {{-- @can('list_favicons')
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::segment(2) == 'favicons' ? 'active' : '' }}"
                                        href="{{ route('post.index') }}">
                                        <div class="d-flex align-items-center">
                                            <i class="fa fa-angle-double-right"></i> Post
                                        </div>
                                    </a>
                                </li>
                            @endcan --}}
                        </ul>

                    </li>
                    </li>

               {{-- @endhasanyrole  --}}

                {{-- End of Site Settings --}}

                {{-- Beginning of Contact Details --}}
                 {{-- @hasanyrole('superadmin')  --}}

                <li class="nav-item">
                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                        <div class="col-auto navbar-vertical-label">Parcel</div>
                        <div class="col ps-0">
                            <hr class="mb-0 navbar-vertical-divider">
                        </div>
                    </div>
                    <li class="nav-item">
                        <a class="{{ Request::segment(2) == 'contact-details' ? '' : 'collapsed' }}"
                            href="{{ route('api.parcels.index') }}" role="button" data-bs-toggle="collapse"
                            aria-expanded="{{ Request::segment(2) == 'contact-details' ? 'true' : 'false' }}"
                            aria-controls="dashboard18">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon"><i class="fas fa-users"></i></span>
                                <a href="{{ route('api.parcels.index') }}">
                                <span class="nav-link-text ps-1">Parcel</span></a>
                            </div>
                        </a>
                        {{-- @endhasanyrole  --}}

                    <li class="nav-item">
                        <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                            <div class="col-auto navbar-vertical-label">Tracking Updates</div>
                            <div class="col ps-0">
                                <hr class="mb-0 navbar-vertical-divider">

                            </div>
                        </div>

                        <li class="nav-item">
                            <a class="{{ Request::segment(2) == 'contact-details' ? '' : 'collapsed' }}"
                                href="{{ route('api.tracking-updates.index') }}" role="button" data-bs-toggle="collapse"
                                aria-expanded="{{ Request::segment(2) == 'contact-details' ? 'true' : 'false' }}"
                                aria-controls="dashboard18">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-icon"><i class="fas fa-file-signature"></i></span>
                                    <a href="{{ route('api.tracking-updates.index') }}">
                                    <span class="nav-link-text ps-1">Tracking Updates</span></a>
                                </div>
                            </a>

                            <li class="nav-item">
                                <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                    <div class="col-auto navbar-vertical-label">Parcel Histories</div>
                                    <div class="col ps-0">
                                        <hr class="mb-0 navbar-vertical-divider">
                                    </div>
                                </div>
                                <li class="nav-item">
                                    <a class="{{ Request::segment(2) == 'contact-details' ? '' : 'collapsed' }}"
                                        href="{{ route('api.parcel-histories.index') }}" role="button" data-bs-toggle="collapse"
                                        aria-expanded="{{ Request::segment(2) == 'contact-details' ? 'true' : 'false' }}"
                                        aria-controls="dashboard18">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-icon"><i class="fas fa-cogs"></i></span>
                                            <a href="{{ route('api.parcel-histories.index') }}">
                                            <span class="nav-link-text ps-1">Parcel Histories</span></a>
                                        </div>
                                    </a>
                        
                                    {{-- <li class="nav-item">
                                        <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                            <div class="col-auto navbar-vertical-label">Permission</div>
                                            <div class="col ps-0">
                                                <hr class="mb-0 navbar-vertical-divider">
                                            </div>
                                        </div>
                                        <li class="nav-item">
                                            <a class="{{ Request::segment(2) == 'contact-details' ? '' : 'collapsed' }}"
                                                href="#" role="button" data-bs-toggle="collapse"
                                                aria-expanded="{{ Request::segment(2) == 'contact-details' ? 'true' : 'false' }}"
                                                aria-controls="dashboard18">
                                                <div class="d-flex align-items-center">
                                                    <span class="nav-link-icon"><i class="fas fa-diagnoses"></i></span>
                                                    <a href="#">
                                                    <span class="nav-link-text ps-1">Permission</span></a>
                                                </div>
                                            </a>

                            <ul class="nav collapse {{ Request::segment(2) == 'contact-details' ? 'show' : '' }}"
                                id="dashboard18">
 --}}


                                {{-- Visitors Book --}}
                                {{-- @can('list_visitors_book')
                                    <li class="nav-item">
                                        <a class="nav-link {{ Request::segment(2) == 'contact-details' && Request::segment(3) == 'visitors-book' ? 'active' : '' }}"
                                            href="{{ route('admin.visitors-book.index') }}">
                                            <div class="d-flex align-items-center"><i class="fa fa-angle-double-right"></i>
                                                Visitors Book
                                            </div>
                                        </a>
                                    </li>
                                @endcan --}}
                                {{-- Student Details --}}
                                {{-- @can('list_student_details')
                                    <li class="nav-item">
                                        <a class="nav-link {{ Request::segment(2) == 'contact-details' && Request::segment(3) == 'student-details' ? 'active' : '' }}"
                                            href="{{ route('admin.student-details.index') }}">
                                            <div class="d-flex align-items-center"><i class="fa fa-angle-double-right"></i>
                                                Student Details
                                            </div>
                                        </a>
                                    </li>
                                @endcan --}}
                                {{-- Contacts --}}
                                {{-- @can('list_contacts')
                                    <li class="nav-item">
                                        <a class="nav-link {{ Request::segment(2) == 'contact-details' && Request::segment(3) == 'contacts' ? 'active' : '' }}"
                                            href="{{ route('admin.contacts.index') }}">
                                            <div class="d-flex align-items-center"><i class="fa fa-angle-double-right"></i>
                                               Post
                                            </div>
                                        </a>
                                    </li>
                                @endcan --}}
                            </ul>
                        </li>
                    </li>

                {{-- @endhasanyrole --}}
                {{-- End of Contact Details --}}

            </ul>
        </div>
    </div>

</nav>