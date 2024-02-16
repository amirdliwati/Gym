@if ($Role->permissions->where('title','AddTrainee') != '[]')
    <li><a href="/AddTrainee" class="nav-link nav-link-custom"><span><i data-feather="user-plus"></i>{{__('Add Trainee')}}</span></a></li>
@endif

@if ($Role->permissions->where('title','ManageTrainee') != '[]')
    <li><a href="/Trainees" class="nav-link nav-link-custom"><span><i data-feather="users"></i>{{__('Manage Trainees')}}</span></a></li>
@endif

@if ($Role->permissions->whereIn('title',['OfferManage']) != '[]')
    <li class="dropdown li-custom"><a class="nav-link menu-title submenu-title-custom" href="#"><i data-feather="gift"></i>{{__('Offers')}}<span class="sub-arrow"><i class="fa fa-chevron-right"></i></span></a>
        <ul class="nav-submenu menu-content nav-sub-childmenu-custom">
            @if ($Role->permissions->where('title','OfferManage') != '[]')
                <li><a href="/Offers"><i class="fa fa-file-text-o text-primary mr-2"></i>{{__('Manage Offers')}}</a></li>
            @endif
        </ul>
    </li>
@endif

@if ($Role->permissions->where('title','TraineeAttend') != '[]')
    <li><a href="/TraineeAttendances" class="nav-link nav-link-custom"><span><i data-feather="calendar"></i>{{__('Attendances')}}</span></a></li>
@endif

@if ($Role->permissions->where('title','MembershipManage') != '[]')
    <li><a href="/Memberships" class="nav-link nav-link-custom"><span><i data-feather="user-check"></i>{{__('Memberships')}}</span></a></li>
@endif

