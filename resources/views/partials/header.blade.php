
<header>
  <nav>
    <ul>
      <li>
        <a href="/">Home</a>
      </li>

      <?php


use Illuminate\Support\Facades\Auth;


if (Auth::user()) {
  print_r('<li>
            <a href="/myprofile">Mijn profiel</a>
          </li>
          <li>
            <a href="/order">Bestel ringen</a>
          </li>
          '
        );
} 

 if (Auth::user()->role_id === 1) {
        print_r('<li>
                  <a href="/dashboard">Dashboard</a>
                </li>'
              );
      } 
      ?>

    </ul>
  </nav>
</header>