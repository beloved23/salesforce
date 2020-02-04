

      <script>
  $("#usersListForSelection").select2(
     {
  ajax: {
    url: app_url+"users/search",
    dataType: 'json',
    delay: 250,
    data: function (params) {
      return {
        q: params.term, // search term
        page: params.page
      };
    },
    processResults: function (data, params) {
      // parse the results into the format expected by Select2
      // since we are using custom formatting functions we do not need to
      // alter the remote JSON data, except to indicate that infinite
      // scrolling can be used
      params.page = params.page || 1;

      return {
        results: data.items,
        pagination: {
          more: (params.page * 30) < data.total_count
        }
      };
    },
    cache: true
  },
  placeholder: 'Search for a User',
  escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
  minimumInputLength: 3,
templateResult: formatRepo,
  templateSelection: formatRepoSelection  
}
  );
  function formatRepo (repo) {
  if (repo.loading) {
    return repo.auuid;
  }
 var markup =  "<a href='javascript:void(0);'>"+
                 "<div class='user-img'>"+
                "<img style='width:40px;height:40px;' src='" + app_url +"storage/"+repo.profile_main.profile_picture+ "' alt='user' class='img-circle'>"+
                 "<span class='profile-status busy pull-right'></span>"+
                " </div><div style='color:black' class='mail-contnet hover-white'>"+
                "<span> User AUUID: " +repo.auuid+ " <span style='padding-right:10px;'> Email  "+repo.email +" </span></span>"+
                "</div></a>";
  return markup;
}

function formatRepoSelection (repo) {
  return repo.profile_main.last_name+' '+repo.profile_main.first_name;
}
</script>
