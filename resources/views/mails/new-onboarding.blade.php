<p>Bonjour !</p>
<p>
	Un nouvel étudiant vient de s'inscrire.<br>
	Vous pouvez retrouver l'inscription ici :
	<a href="{{ route("registrations", ["uid" => $registration->uid]) }}#uid-{{ $registration->uid }}">
		inscription.<br>
	</a>
	Ou vous pouvez retrouver toutes les inscriptions ici :
	<a href="{{ route("registrations") }}">liste des inscriptions.</a>
</p>
