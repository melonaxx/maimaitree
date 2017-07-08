<li class="header">MAIN NAVIGATION</li>
<li class="active treeview">
    <a href="#">
        <i class="fa fa-dashboard"></i>
        <span>Dashboard</span>
        <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="active">
            <a href="index.html">
                <i class="fa fa-circle-o"></i> Dashboard v1
            </a>
        </li>
    </ul>
</li>
<li>
    <a href="documentation/index.html">
        <i class="fa fa-book"></i>
        <span>Documentation</span>
    </a>
</li>
<li class="header">LABELS</li>
<li>
    <a href="#">
        <i class="fa fa-circle-o text-red"></i>
        <span>Important</span>
    </a>
</li>
<li class="{{ Request::is('recordWorks*') ? 'active' : '' }}">
    <a href="{!! route('recordWorks.index') !!}"><i class="fa fa-edit"></i><span>RecordWorks</span></a>
</li>

