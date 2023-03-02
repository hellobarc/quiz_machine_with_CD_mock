<aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar position-relative">	
	  	<div class="multinav">
		  <div class="multinav-scroll" style="height: 100%;">	
			  <!-- sidebar menu-->
			  <ul class="sidebar-menu" data-widget="tree">	
				<li class="header">Dashboard</li>
				<li class="treeview">
				  <a href="#">
					<i class="icon-Layout-4-blocks"><span class="path1"></span><span class="path2"></span></i>
					<span>Dashboard</span>
					<span class="pull-right-container">
					  <i class="fa fa-angle-right pull-right"></i>
					</span>
				  </a>
				  <ul class="treeview-menu">
					<li><a href="{{route('admin.dashboard')}}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Dashboard</a></li>
				  </ul>
				</li>
				<li class="treeview">
				  <a href="#">
					<i span class="fa-solid fa-user"><span class="path1"></span><span class="path2"></span></i>
					<span>User</span>
					<span class="pull-right-container">
					  <i class="fa fa-angle-right pull-right"></i>
					</span>
				  </a>
				  <ul class="treeview-menu">
					<li><a href="{{route('admin.users')}}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>All User</a></li>
				  </ul>
				</li>
				<li class="treeview">
				  <a href="#">
					<i span class="icon-Layout-grid"><span class="path1"></span><span class="path2"></span></i>
					<span>Settings</span>
					<span class="pull-right-container">
					  <i class="fa fa-angle-right pull-right"></i>
					</span>
				  </a>
				  <ul class="treeview-menu">
					<li><a href="{{route('admin.users')}}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>All User</a></li>
					<li><a href="{{route('admin.settings.level')}}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Level</a></li>
					<li><a href="{{route('admin.settings.category')}}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Category</a></li>
					<li><a href="contact_app_chat.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Site Setting</a></li>
				  </ul>
				</li>
				<li class="treeview">
				  <a href="#">
					<i span class="fa-solid fa-clipboard"><span class="path1"></span><span class="path2"></span></i>
					<span>Content</span>
					<span class="pull-right-container">
					  <i class="fa fa-angle-right pull-right"></i>
					</span>
				  </a>
				  <ul class="treeview-menu">
					<li><a href="{{route('admin.settings.exam')}}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Manage Exam</a></li>
					<li><a href="{{route('admin.settings.quiz')}}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Manage Quiz</a></li>
				  </ul>
				</li>
				<li class="treeview">
				  <a href="#">
					<i class="fa-solid fa-computer"></i><span class="path1"></span><span class="path2"></span></i>
					<span>CD Mock</span>
					<span class="pull-right-container">
					  <i class="fa fa-angle-right pull-right"></i>
					</span>
				  </a>
				  <ul class="treeview-menu">
					<li><a href="{{route('admin.settings.mock')}}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Manage Mock</a></li>
					<li><a href="{{route('admin.settings.mock.exercise')}}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Mock Exercise</a></li>
					<li><a href="{{route('admin.settings.mock.questions')}}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Mock Questions</a></li>
					<li><a href="{{route('admin.settings.mock.passage')}}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Mock Add Passage</a></li>
					<li><a href="{{route('admin.settings.mock.audio')}}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Mock Add Audio</a></li>
				  </ul>
				</li>
			  </ul>
		  </div>
		</div>
    </section>
	<div class="sidebar-footer">
		<a href="javascript:void(0)" class="link" data-bs-toggle="tooltip" title="Settings"><span class="icon-Settings-2"></span></a>
		<a href="mailbox.html" class="link" data-bs-toggle="tooltip" title="Email"><span class="icon-Mail"></span></a>
		<a href="javascript:void(0)" class="link" data-bs-toggle="tooltip" title="Logout"><span class="icon-Lock-overturning"><span class="path1"></span><span class="path2"></span></span></a>
	</div>
  </aside>