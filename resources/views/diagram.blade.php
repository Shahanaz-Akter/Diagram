<html>
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gojs/2.1.54/go.js"></script>
    {{-- GoJS --}}
    <style>
        #myDiagramDiv {
            width: 100%;
            height: 600px;
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <div id="myDiagramDiv"></div>
    <button onclick="saveDiagram()">Save</button>

    <script>
        function init() {
            const $ = go.GraphObject.make;
            const myDiagram = $(go.Diagram, "myDiagramDiv", {
                "undoManager.isEnabled": true
            });

            myDiagram.nodeTemplate =
                $(go.Node, "Auto",
                    $(go.Shape, "RoundedRectangle", { strokeWidth: 0 },
                        new go.Binding("fill", "color")),
                    $(go.TextBlock, { margin: 8 },
                        new go.Binding("text", "key"))
                );

            myDiagram.model = new go.GraphLinksModel(
                [{ key: "Alpha", color: "lightblue" },
                 { key: "Beta", color: "orange" }],
                [{ from: "Alpha", to: "Beta" }]
            );
        }

        function saveDiagram() {
            const diagramData = myDiagram.model.toJson();
            // Send diagramData to the server to save in the database
        }

        init();
    </script>

<script>
    async function saveDiagram() {
        const diagramData = myDiagram.model.toJson();

        const response = await fetch('/save-diagram', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ data: diagramData })
        });

        const result = await response.json();
        if (result.success) {
            alert('Diagram saved successfully!');
        } else {
            alert('Failed to save the diagram.');
        }
    }
</script>

</body>
</html>
