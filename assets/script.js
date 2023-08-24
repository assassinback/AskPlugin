JQuery(document).ready(function() {
    JQuery('.table td').on('click', function() 
    {
      JQuery(this).closest('table').find('tr.clickedrow').removeClass('clickedrow');
      // add highlight to the parent tr of the clicked td
      JQuery(this).closest('tr').addClass("clickedrow");
    });
  });