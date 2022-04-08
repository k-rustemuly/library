export class CanvasGraphics {
    constructor(canvasCtx: any, commonObjs: any, objs: any, canvasFactory: any, imageLayer: any, optionalContentConfig: any, annotationCanvasMap: any);
    ctx: any;
    current: CanvasExtraState;
    stateStack: any[];
    pendingClip: {} | null;
    pendingEOFill: boolean;
    res: any;
    xobjs: any;
    commonObjs: any;
    objs: any;
    canvasFactory: any;
    imageLayer: any;
    groupStack: any[];
    processingType3: any;
    baseTransform: any;
    baseTransformStack: any[];
    groupLevel: number;
    smaskStack: any[];
    smaskCounter: number;
    tempSMask: any;
    suspendedCtx: any;
    contentVisible: boolean;
    markedContentStack: any[];
    optionalContentConfig: any;
    cachedCanvases: CachedCanvases;
    cachedPatterns: Map<any, any>;
    annotationCanvasMap: any;
    viewportScale: number;
    outputScaleX: number;
    outputScaleY: number;
    _cachedGetSinglePixelWidth: number | null;
    beginDrawing({ transform, viewport, transparency, background, }: {
        transform: any;
        viewport: any;
        transparency?: boolean | undefined;
        background?: null | undefined;
    }): void;
    compositeCtx: any;
    transparentCanvas: any;
    _combinedScaleFactor: number | undefined;
    executeOperatorList(operatorList: any, executionStartIdx: any, continueCallback: any, stepper: any): any;
    endDrawing(): void;
    _scaleImage(img: any, inverseTransform: any): {
        img: any;
        paintWidth: any;
        paintHeight: any;
    };
    _createMaskCanvas(img: any): {
        canvas: any;
        offsetX: number;
        offsetY: number;
    };
    setLineWidth(width: any): void;
    setLineCap(style: any): void;
    setLineJoin(style: any): void;
    setMiterLimit(limit: any): void;
    setDash(dashArray: any, dashPhase: any): void;
    setRenderingIntent(intent: any): void;
    setFlatness(flatness: any): void;
    setGState(states: any): void;
    get inSMaskMode(): boolean;
    checkSMaskState(): void;
    /**
     * Soft mask mode takes the current main drawing canvas and replaces it with
     * a temporary canvas. Any drawing operations that happen on the temporary
     * canvas need to be composed with the main canvas that was suspended (see
     * `compose()`). The temporary canvas also duplicates many of its operations
     * on the suspended canvas to keep them in sync, so that when the soft mask
     * mode ends any clipping paths or transformations will still be active and in
     * the right order on the canvas' graphics state stack.
     */
    beginSMaskMode(): void;
    endSMaskMode(): void;
    compose(dirtyBox: any): void;
    save(): void;
    restore(): void;
    transform(a: any, b: any, c: any, d: any, e: any, f: any): void;
    constructPath(ops: any, args: any): void;
    closePath(): void;
    stroke(consumePath: any): void;
    closeStroke(): void;
    fill(consumePath: any): void;
    eoFill(): void;
    fillStroke(): void;
    eoFillStroke(): void;
    closeFillStroke(): void;
    closeEOFillStroke(): void;
    endPath(): void;
    clip(): void;
    eoClip(): void;
    beginText(): void;
    endText(): void;
    setCharSpacing(spacing: any): void;
    setWordSpacing(spacing: any): void;
    setHScale(scale: any): void;
    setLeading(leading: any): void;
    setFont(fontRefName: any, size: any): void;
    setTextRenderingMode(mode: any): void;
    setTextRise(rise: any): void;
    moveText(x: any, y: any): void;
    setLeadingMoveText(x: any, y: any): void;
    setTextMatrix(a: any, b: any, c: any, d: any, e: any, f: any): void;
    nextLine(): void;
    paintChar(character: any, x: any, y: any, patternTransform: any, resetLineWidthToOne: any): void;
    pendingTextPaths: any[] | undefined;
    get isFontSubpixelAAEnabled(): any;
    showText(glyphs: any): void;
    showType3Text(glyphs: any): void;
    setCharWidth(xWidth: any, yWidth: any): void;
    setCharWidthAndBounds(xWidth: any, yWidth: any, llx: any, lly: any, urx: any, ury: any): void;
    getColorN_Pattern(IR: any): any;
    setStrokeColorN(...args: any[]): void;
    setFillColorN(...args: any[]): void;
    setStrokeRGBColor(r: any, g: any, b: any): void;
    setFillRGBColor(r: any, g: any, b: any): void;
    _getPattern(objId: any, matrix?: null): any;
    shadingFill(objId: any): void;
    beginInlineImage(): void;
    beginImageData(): void;
    paintFormXObjectBegin(matrix: any, bbox: any): void;
    paintFormXObjectEnd(): void;
    beginGroup(group: any): void;
    endGroup(group: any): void;
    beginAnnotations(): void;
    endAnnotations(): void;
    beginAnnotation(id: any, rect: any, transform: any, matrix: any, hasOwnCanvas: any): void;
    annotationCanvas: any;
    endAnnotation(): void;
    paintImageMaskXObject(img: any): void;
    paintImageMaskXObjectRepeat(imgData: any, scaleX: any, skewX: number | undefined, skewY: number | undefined, scaleY: any, positions: any): void;
    paintImageMaskXObjectGroup(images: any): void;
    paintImageXObject(objId: any): void;
    paintImageXObjectRepeat(objId: any, scaleX: any, scaleY: any, positions: any): void;
    paintInlineImageXObject(imgData: any): void;
    paintInlineImageXObjectGroup(imgData: any, map: any): void;
    paintSolidColorImageMask(): void;
    markPoint(tag: any): void;
    markPointProps(tag: any, properties: any): void;
    beginMarkedContent(tag: any): void;
    beginMarkedContentProps(tag: any, properties: any): void;
    endMarkedContent(): void;
    beginCompat(): void;
    endCompat(): void;
    consumePath(clipBox: any): void;
    getSinglePixelWidth(): number;
    getCanvasPosition(x: any, y: any): any[];
    isContentVisible(): boolean;
}
declare class CanvasExtraState {
    constructor(width: any, height: any);
    alphaIsShape: boolean;
    fontSize: number;
    fontSizeScale: number;
    textMatrix: number[];
    textMatrixScale: number;
    fontMatrix: number[];
    leading: number;
    x: number;
    y: number;
    lineX: number;
    lineY: number;
    charSpacing: number;
    wordSpacing: number;
    textHScale: number;
    textRenderingMode: number;
    textRise: number;
    fillColor: string;
    strokeColor: string;
    patternFill: boolean;
    fillAlpha: number;
    strokeAlpha: number;
    lineWidth: number;
    activeSMask: any;
    transferMaps: any;
    clone(): any;
    setCurrentPoint(x: any, y: any): void;
    updatePathMinMax(transform: any, x: any, y: any): void;
    minX: any;
    minY: any;
    maxX: any;
    maxY: any;
    updateCurvePathMinMax(transform: any, x0: any, y0: any, x1: any, y1: any, x2: any, y2: any, x3: any, y3: any): void;
    getPathBoundingBox(pathType?: string, transform?: null): any[];
    updateClipFromPath(): void;
    startNewPathAndClipBox(box: any): void;
    clipBox: any;
    getClippedPathBoundingBox(pathType?: string, transform?: null): any[] | null;
}
declare class CachedCanvases {
    constructor(canvasFactory: any);
    canvasFactory: any;
    cache: any;
    getCanvas(id: any, width: any, height: any, trackTransform: any): any;
    clear(): void;
}
export {};
