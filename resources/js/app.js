require('./bootstrap');

window.Vue = require('vue');

import MarkerClusterer from '@google/markerclusterer';

import gmapsInit from './gmap.js';
 
const app = new Vue({
    el: '#app',
    data: {
        test: 'yoo',
        locations: [
            {
              position: {
                lat: 48.160910,
                lng: 16.383330,
              },
            },
            {
              position: {
                lat: 48.174270,
                lng: 16.329620,
              },
            },
            {
              position: {
                lat: 48.146140,
                lng: 16.297030,
              },
            },
            {
              position: {
                lat: 48.135830,
                lng: 16.194460,
              },
            },
            {
              position: {
                lat: 48.306091,
                lng: 14.286440,
              },
            },
            {
              position: {
                lat: 47.503040,
                lng: 9.747070,
              },
            },
        ]
    },
    async mounted() {
        try {
            const google = await gmapsInit();
            const geocoder = new google.maps.Geocoder();
            const map = new google.maps.Map(this.$el);
      
            geocoder.geocode({ address: `London` }, (results, status) => {
              if (status !== `OK` || !results[0]) {
                throw new Error(status);
              }
      
              map.setCenter(results[0].geometry.location);
              map.fitBounds(results[0].geometry.viewport);
            });
      
            const markerClickHandler = (marker) => {
              map.setZoom(13);
              map.setCenter(marker.getPosition());
            };
      
            const markers = this.locations
              .map((location) => {
                const marker = new google.maps.Marker({ ...location, map });
                marker.addListener(`click`, () => markerClickHandler(marker));
      
                return marker;
              });
      
            // eslint-disable-next-line no-new
            new MarkerClusterer(map, markers, {
              imagePath: `https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m`,
            });
          } catch (error) {
            // eslint-disable-next-line no-console
            console.error(error);
          }
    }
});
