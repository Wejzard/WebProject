let EventService = {
  loadAll: function(category = "POP") {
    const url = `/events/category/${category}`;

    RestClient.get(url, function(events) {
      console.log("✅ Events loaded:", events);

      Utils.datatable("events-table", [
        { data: 'title', title: 'Title' },
        { data: 'date', title: 'Event Date' },
        { data: 'location', title: 'Location' },
        { data: 'price', title: 'Price' },
        { data: 'category', title: 'Category' }
      ], events, 10);
    }, function(xhr) {
      toastr.error(xhr.responseJSON?.message || "Could not load events.");
    });
  }
};