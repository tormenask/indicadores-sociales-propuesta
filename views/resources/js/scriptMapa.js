document.addEventListener("DOMContentLoaded", () => {
    const map = L.map("map").setView([3.4516, -76.532], 12);
  
    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
      attribution: "&copy; OpenStreetMap contributors",
    }).addTo(map);
  
    fetch("/views/resources/geojson/comunas.geojson")
      .then((response) => response.json())
      .then((data) => {
        console.log(JSON.stringify(data));
        const getColor = (value) => {
          return value > 80
            ? "#006837"
            : value > 60
            ? "#31a354"
            : value > 40
            ? "#78c679"
            : value > 20
            ? "#c2e699"
            : "#ffffcc";
        };
  
        const defaultStyle = {
          weight: 2,
          color: "white",
          fillOpacity: 0.7,
        };
  
        const highlightStyle = {
          weight: 5,
          color: "#666",
          fillOpacity: 0.9,
        };
        
        let selectedLayer = null;
        function popup(feature, layer) {
          if (feature.properties.comuna && feature.properties.nombre) {
            layer.bindPopup("<strong>Comuna:</>" + feature.properties.comuna);
          }
        }
  
        const onEachFeature = (feature, layer) => {
          popup(feature, layer);
  
          layer.on("mouseover", () => {
            if (layer !== selectedLayer) {
              layer.setStyle(highlightStyle);
            }
          });
  
          layer.on("mouseout", () => {
            if (layer !== selectedLayer) {
              layer.setStyle(defaultStyle);
            }
          });
  
          layer.on("click", () => {
            if (selectedLayer) {
              selectedLayer.setStyle(defaultStyle);
            }
  
            // Aplicar highlightStyle a la nueva capa seleccionada
            layer.setStyle(highlightStyle);
  
            // Actualizar la capa seleccionada
            selectedLayer = layer;
            document.getElementById("info-content").innerHTML = `
              <h4 class="numero_comuna dato_comuna_titulo">${feature.properties.NOMBRE}</h4>
              <div class="datos_comuna">
                <p class="dato_comuna_titulo">Valor:</p>
                <p class="valor_comuna dato_comuna_detalle">${feature.properties.PERIMETRO}%</p>
              </div>
              <div class="datos_comuna">
                <p class="dato_comuna_titulo">Perimetro:</p>
                <p class="poblacion_comuna dato_comuna_detalle">${feature.properties.PERIMETRO} PERIMETRO</p>
              </div>
              <div class="datos_comuna">
                <p class="dato_comuna_titulo">Área:</p>
                <p class="area_comuna dato_comuna_detalle">${feature.properties.AREA} km²</p>
              </div>
              <div class="datos_comuna">
                <p class="dato_comuna_titulo">Densidad:</p>
                <p class="densidad_comuna dato_comuna_detalle">${feature.properties.PERIMETRO} hab/km²</p>
              </div>
                
              `;
          });
        };
        L.geoJSON(data, {
          style: () => defaultStyle,
          onEachFeature: onEachFeature,
        }).addTo(map);
      })
      .catch((error) => console.error("Error cargando los datos:", error));
  });
  