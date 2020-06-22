  <script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script> 
      <script>
new TWTR.Widget({
  version: 2,
  type: 'profile',
  rpp: 5,
  interval: 30000,
  width: 280,
  height: 350,
  theme: {
    shell: {
      background: '#FFFFFF',
      color: '#013e59'
    },
    tweets: {
      background: '#ffffff',
      color: '#666666',
      links: '#013e59'
    }
  },
  features: {
    scrollbar: false,
    loop: false,
    live: true,
    behavior: 'all'
  }
}).render().setUser('aprendeAnahuac').start();
</script> 