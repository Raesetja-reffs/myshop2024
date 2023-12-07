
/****** Object:  Table [dbo].[aaaDeliveryAddresses]    Script Date: 06/12/2023 10:36:41 AM ******/

CREATE TABLE [dbo].[aaaDeliveryAddresses](
	[CustomerCode] [nvarchar](6) NOT NULL,
	[CustDelivCode] [nvarchar](10) NULL,
	[SalesmanCode] [nvarchar](5) NULL,
	[Contact] [nvarchar](16) NULL,
	[Telephone] [nvarchar](16) NULL,
	[Cell] [nvarchar](16) NULL,
	[Fax] [nvarchar](16) NULL,
	[DelAddress01] [nvarchar](30) NULL,
	[DelAddress02] [nvarchar](30) NULL,
	[DelAddress03] [nvarchar](30) NULL,
	[DelAddress04] [nvarchar](30) NULL,
	[DelAddress05] [nvarchar](30) NULL,
	[Email] [nvarchar](200) NULL,
	[ContactDocs] [nvarchar](16) NULL,
	[EmailDocs] [nvarchar](200) NULL,
	[ContactStatement] [nvarchar](16) NULL,
	[EmailStatement] [nvarchar](200) NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[aaaMyCustDelAddresses]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[aaaMyCustDelAddresses](
	[CustomerCode] [nvarchar](6) NOT NULL,
	[CustDelivCode] [nvarchar](10) NULL,
	[SalesmanCode] [nvarchar](5) NULL,
	[Contact] [nvarchar](16) NULL,
	[Telephone] [nvarchar](16) NULL,
	[Cell] [nvarchar](16) NULL,
	[Fax] [nvarchar](16) NULL,
	[DelAddress01] [nvarchar](30) NULL,
	[DelAddress02] [nvarchar](30) NULL,
	[DelAddress03] [nvarchar](30) NULL,
	[DelAddress04] [nvarchar](30) NULL,
	[DelAddress05] [nvarchar](30) NULL,
	[Email] [nvarchar](200) NULL,
	[ContactDocs] [nvarchar](16) NULL,
	[EmailDocs] [nvarchar](200) NULL,
	[ContactStatement] [nvarchar](16) NULL,
	[EmailStatement] [nvarchar](200) NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[aaMyTempCustomers]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[aaMyTempCustomers](
	[CustomerCode] [nvarchar](6) NOT NULL,
	[CustomerDesc] [nvarchar](40) NULL,
	[PostAddress01] [nvarchar](30) NULL,
	[PostAddress02] [nvarchar](30) NULL,
	[PostAddress03] [nvarchar](30) NULL,
	[PostAddress04] [nvarchar](30) NULL,
	[PostAddress05] [nvarchar](30) NULL,
	[TaxCode] [int] NULL,
	[ExemptRef] [nvarchar](16) NULL,
	[SettlementTerms] [int] NULL,
	[PaymentTerms] [int] NULL,
	[Blocked] [nvarchar](5) NULL,
	[IncExc] [nvarchar](5) NULL,
	[CreditLimit] [bigint] NULL,
	[UserDefined01] [nvarchar](16) NULL,
	[UserDefined02] [nvarchar](16) NULL,
	[UserDefined03] [nvarchar](16) NULL,
	[UserDefined04] [nvarchar](16) NULL,
	[UserDefined05] [nvarchar](16) NULL,
	[PriceRegime] [int] NULL,
	[Balance] [money] NULL,
	[Category] [nvarchar](50) NULL,
	[Discount] [money] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[aaPervOverallSpecials]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[aaPervOverallSpecials](
	[ItemCode] [nvarchar](20) NULL,
	[PriceIncl] [money] NULL,
	[PriceExcl] [money] NULL,
	[StartDate] [date] NULL,
	[EndDate] [date] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[aatblCustSpecials]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[aatblCustSpecials](
	[CustomerCode] [nvarchar](20) NULL,
	[ItemCode] [nvarchar](20) NULL,
	[ExpDate] [nvarchar](20) NULL,
	[Qty01] [money] NULL,
	[Price01] [money] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[aMultistore]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[aMultistore](
	[ItemCode] [nvarchar](15) NOT NULL,
	[LastPurchAmt] [float] NULL,
	[CostThis13] [float] NULL,
	[QtyOnHand] [float] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[apastelcust]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[apastelcust](
	[CustomerCode] [nvarchar](6) NOT NULL,
	[CustomerDesc] [nvarchar](40) NULL,
	[PostAddress01] [nvarchar](30) NULL,
	[PostAddress02] [nvarchar](30) NULL,
	[PostAddress03] [nvarchar](30) NULL,
	[PostAddress04] [nvarchar](30) NULL,
	[PostAddress05] [nvarchar](30) NULL,
	[TaxCode] [int] NULL,
	[ExemptRef] [nvarchar](16) NULL,
	[SettlementTerms] [int] NULL,
	[PaymentTerms] [int] NULL,
	[Blocked] [nvarchar](5) NULL,
	[IncExc] [nvarchar](5) NULL,
	[CreditLimit] [bigint] NULL,
	[UserDefined01] [nvarchar](16) NULL,
	[UserDefined02] [nvarchar](16) NULL,
	[UserDefined03] [nvarchar](16) NULL,
	[UserDefined04] [nvarchar](16) NULL,
	[UserDefined05] [nvarchar](16) NULL,
	[PriceRegime] [int] NULL,
	[Balance] [money] NULL,
	[Category] [nvarchar](50) NULL,
	[Discount] [money] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[atblLogging]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[atblLogging](
	[intBrandId] [int] NOT NULL,
	[strType] [nvarchar](50) NOT NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[aTempDelAddresses]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[aTempDelAddresses](
	[CustomerCode] [nvarchar](6) NOT NULL,
	[CustDelivCode] [nvarchar](10) NULL,
	[SalesmanCode] [nvarchar](5) NULL,
	[Contact] [nvarchar](16) NULL,
	[Telephone] [nvarchar](16) NULL,
	[Cell] [nvarchar](16) NULL,
	[Fax] [nvarchar](16) NULL,
	[DelAddress01] [nvarchar](30) NULL,
	[DelAddress02] [nvarchar](30) NULL,
	[DelAddress03] [nvarchar](30) NULL,
	[DelAddress04] [nvarchar](30) NULL,
	[DelAddress05] [nvarchar](30) NULL,
	[Email] [nvarchar](200) NULL,
	[ContactDocs] [nvarchar](16) NULL,
	[EmailDocs] [nvarchar](200) NULL,
	[ContactStatement] [nvarchar](16) NULL,
	[EmailStatement] [nvarchar](200) NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[CreditNoteHeader]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[CreditNoteHeader](
	[DocNumber] [varchar](50) NOT NULL,
	[DocDate] [varchar](50) NOT NULL,
	[CustomerNumber] [varchar](50) NOT NULL,
	[SoldTo] [varchar](500) NOT NULL,
	[ShipTo] [varchar](500) NOT NULL,
	[Subtotal] [nvarchar](50) NOT NULL,
	[Tax] [nvarchar](50) NOT NULL,
	[Total] [nvarchar](50) NOT NULL,
	[OriginalDocNumber] [nvarchar](50) NOT NULL,
	[intFlag] [int] NOT NULL,
	[ErrorMessage] [nvarchar](250) NULL,
	[DIMS_ReturnId] [nvarchar](50) NULL,
	[PaymentTerms] [nvarchar](50) NULL,
	[CreditNoteReason] [nvarchar](50) NULL,
	[BatchReportPrinted] [bit] NULL,
	[InvoiceRef] [nvarchar](50) NULL,
	[HeaderDiscount] [nvarchar](50) NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[DIMSPRICE LIST]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[DIMSPRICE LIST](
	[Code] [varchar](50) NULL,
	[PastelDescription] [varchar](50) NULL,
	[ Item ] [varchar](50) NULL,
	[From ] [varchar](50) NULL,
	[To] [varchar](50) NULL,
	[Price] [varchar](50) NULL,
	[GroupId] [varchar](50) NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[DriversCashOffReceipts]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[DriversCashOffReceipts](
	[intID] [bigint] IDENTITY(1,1) NOT NULL,
	[intDocumentType] [int] NULL,
	[strDocNumber] [nvarchar](50) NULL,
	[strCustomerCode] [nvarchar](50) NULL,
	[strPartialReceiptNo] [nvarchar](255) NULL,
	[strInv] [nvarchar](50) NULL,
	[strAccountToPost] [nvarchar](255) NULL,
	[strCashControlAccount] [int] NULL,
	[dteDocDate] [date] NULL,
	[decCash] [money] NULL,
	[decChq] [money] NULL,
	[bitExported] [bit] NOT NULL,
	[strExportReference] [nvarchar](255) NULL,
	[decInvoiceAmount] [money] NULL,
	[intOwnerId] [int] NULL,
	[intUserId] [int] NULL,
 CONSTRAINT [PK_DriversCashOffReceipts] PRIMARY KEY CLUSTERED
(
	[intID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[DriversCashOffRPJ]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[DriversCashOffRPJ](
	[intJournalID] [bigint] IDENTITY(1,1) NOT NULL,
	[intDocumentType] [int] NULL,
	[strDocNumber] [nvarchar](50) NULL,
	[dteDocDate] [datetime] NULL,
	[strHeaderComment] [nvarchar](50) NULL,
	[strJournalN] [nvarchar](255) NULL,
	[strHeaderAccount] [nvarchar](255) NULL,
	[decTotalP] [money] NULL,
	[decTotalR] [money] NULL,
	[bitJournalExport] [bit] NOT NULL,
	[strJournalExportReason] [nvarchar](255) NULL,
	[intUserId] [int] NULL,
	[intTaxType] [int] NULL,
	[decTaxAmount] [money] NULL,
 CONSTRAINT [PK_DriversCashOffRPJ] PRIMARY KEY CLUSTERED
(
	[intJournalID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[DriversCashOffRPJDT]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[DriversCashOffRPJDT](
	[intID] [bigint] IDENTITY(1,1) NOT NULL,
	[intJournalID] [bigint] NOT NULL,
	[intDocumentType] [int] NULL,
	[strDocNumber] [nvarchar](50) NULL,
	[strLineAccount] [nvarchar](255) NULL,
	[strAccountDescription] [nvarchar](255) NULL,
	[strType] [nvarchar](255) NULL,
	[decAmount] [money] NULL,
	[intUserId] [int] NULL,
 CONSTRAINT [PK_DriversCashOffRPJDT] PRIMARY KEY CLUSTERED
(
	[intID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[HistoryHeader]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[HistoryHeader](
	[DocumentType] [smallint] NULL,
	[DocumentNumber] [nvarchar](8) NULL,
	[CustomerCode] [nvarchar](6) NULL,
	[DocumentDate] [datetime] NULL,
	[OrderNumber] [nvarchar](25) NULL,
	[SalesmanCode] [nvarchar](5) NULL,
	[UserID] [smallint] NULL,
	[ExclIncl] [smallint] NULL,
	[Message01] [nvarchar](30) NULL,
	[Message02] [nvarchar](30) NULL,
	[Message03] [nvarchar](30) NULL,
	[DelAddress01] [nvarchar](30) NULL,
	[DelAddress02] [nvarchar](30) NULL,
	[DelAddress03] [nvarchar](30) NULL,
	[DelAddress04] [nvarchar](30) NULL,
	[DelAddress05] [nvarchar](30) NULL,
	[Terms] [smallint] NULL,
	[ExtraCosts] [smallint] NULL,
	[CostCode] [nvarchar](5) NULL,
	[PPeriod] [smallint] NULL,
	[ClosingDate] [datetime] NULL,
	[Telephone] [nvarchar](16) NULL,
	[Fax] [nvarchar](16) NULL,
	[Contact] [nvarchar](16) NULL,
	[CurrencyCode] [smallint] NULL,
	[ExchangeRate] [float] NULL,
	[DiscountPercent] [float] NULL,
	[Total] [float] NULL,
	[FCurrTotal] [float] NULL,
	[TotalTax] [float] NULL,
	[FCurrTotalTax] [float] NULL,
	[TotalCost] [float] NULL,
	[InvDeleted] [nvarchar](1) NULL,
	[InvPrintStatus] [nvarchar](1) NULL,
	[Onhold] [smallint] NULL,
	[GRNMisc] [nvarchar](1) NULL,
	[Paid] [smallint] NULL,
	[Freight01] [nvarchar](10) NULL,
	[Ship] [nvarchar](16) NULL,
	[IsTMBDoc] [smallint] NULL,
	[Spare] [nvarchar](20) NULL,
	[Exported] [nvarchar](1) NULL,
	[ExportRef] [nvarchar](4) NULL,
	[ExportNum] [int] NULL,
	[Emailed] [nvarchar](1) NULL,
	[CurrentYear] [bit] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[HistoryLines]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[HistoryLines](
	[UserId] [smallint] NULL,
	[DocumentType] [smallint] NULL,
	[DocumentNumber] [nvarchar](8) NULL,
	[ItemCode] [nvarchar](15) NULL,
	[CustomerCode] [nvarchar](7) NULL,
	[SalesmanCode] [nvarchar](5) NULL,
	[SearchType] [smallint] NULL,
	[PPeriod] [smallint] NULL,
	[DDate] [datetime] NULL,
	[UnitUsed] [nvarchar](4) NULL,
	[TaxType] [smallint] NULL,
	[DiscountType] [smallint] NULL,
	[DiscountPercentage] [smallint] NULL,
	[Description] [nvarchar](40) NULL,
	[CostPrice] [float] NULL,
	[Qty] [float] NULL,
	[UnitPrice] [float] NULL,
	[InclusivePrice] [float] NULL,
	[FCurrUnitPrice] [float] NULL,
	[FCurrInclPrice] [float] NULL,
	[TaxAmt] [float] NULL,
	[FCurrTaxAmount] [float] NULL,
	[DiscountAmount] [float] NULL,
	[FCDiscountAmount] [float] NULL,
	[CostCode] [nvarchar](5) NULL,
	[DateTime] [nvarchar](8) NULL,
	[WhichUserDef] [nvarchar](1) NULL,
	[Physical] [smallint] NULL,
	[Fixed] [smallint] NULL,
	[ShowQty] [smallint] NULL,
	[LinkNum] [int] NULL,
	[LinkedNum] [int] NULL,
	[GRNQty] [float] NULL,
	[LinkID] [int] NULL,
	[MultiStore] [nvarchar](3) NULL,
	[IsTMBLine] [smallint] NULL,
	[LinkDocumentType] [smallint] NULL,
	[LinkDocumentNumber] [nvarchar](8) NULL,
	[Exported] [nvarchar](1) NULL,
	[ExportRef] [nvarchar](4) NULL,
	[ExportNum] [int] NULL,
	[QtyLeft] [float] NULL,
	[CaseLotCode] [nvarchar](15) NULL,
	[CaseLotQty] [float] NULL,
	[CaseLotRatio] [float] NULL,
	[CostSyncDone] [int] NULL,
	[CurrentYear] [bit] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[InventoryTransfers]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[InventoryTransfers](
	[strDocNo] [nvarchar](50) NOT NULL,
	[strXML] [xml] NOT NULL,
	[intFlag] [int] NOT NULL,
	[strErrorMessage] [nvarchar](max) NULL,
	[strCompanyName] [nvarchar](50) NOT NULL,
	[intOrderId] [int] NOT NULL,
	[intOutIn] [int] NOT NULL,
 CONSTRAINT [PK_InventoryTransfers] PRIMARY KEY CLUSTERED
(
	[strDocNo] ASC,
	[strCompanyName] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
/****** Object:  Table [dbo].[OrderHeaders]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[OrderHeaders](
	[ID] [nvarchar](50) NULL,
	[OrderDate] [date] NULL,
	[DeliveryDate] [date] NULL,
	[OrderNumber] [nvarchar](50) NULL,
	[CustomerCode] [nvarchar](50) NULL,
	[Notes] [nvarchar](max) NOT NULL,
	[UserName] [nvarchar](50) NULL,
	[ExportedToDims] [bit] NOT NULL,
	[DimsOrderID] [int] NULL,
	[OrigOrderID] [int] NULL,
	[DeliveryAddressID] [int] NULL,
	[bitBackOrder] [bit] NOT NULL,
	[bitCompleted] [bit] NOT NULL,
	[intTransactionType] [int] NOT NULL,
	[contact] [nvarchar](50) NULL,
	[TreatAsQuotation] [bit] NULL,
	[Route] [nvarchar](50) NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
/****** Object:  Table [dbo].[OrderHeadersVan]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[OrderHeadersVan](
	[ID] [nvarchar](50) NULL,
	[OrderDate] [date] NULL,
	[DeliveryDate] [date] NULL,
	[OrderNumber] [nvarchar](50) NULL,
	[CustomerCode] [nvarchar](50) NULL,
	[Notes] [nvarchar](max) NOT NULL,
	[UserName] [nvarchar](50) NULL,
	[ExportedToDims] [bit] NOT NULL,
	[DimsOrderID] [int] NULL,
	[OrigOrderID] [int] NULL,
	[DeliveryAddressID] [int] NULL,
	[bitBackOrder] [bit] NOT NULL,
	[bitCompleted] [bit] NOT NULL,
	[intTransactionType] [int] NOT NULL,
	[contact] [nvarchar](50) NULL,
	[TreatAsQuotation] [bit] NULL,
	[Route] [nvarchar](100) NULL,
	[DeliveryAddress] [nvarchar](150) NULL,
	[intUserId] [int] NULL,
	[strCustomerAddressLine1] [nvarchar](150) NULL,
	[strCustomerAddressLine2] [nvarchar](150) NULL,
	[strCustomerAddressLine3] [nvarchar](150) NULL,
	[strCustomerAddressLine4] [nvarchar](150) NULL,
	[bitClickAndCollect] [bit] NULL,
	[bitPaid] [bit] NULL,
	[strCardGui] [nvarchar](250) NULL,
	[strSignature] [nvarchar](max) NULL,
	[strCoordinates] [nvarchar](250) NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
/****** Object:  Table [dbo].[OrderLines]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[OrderLines](
	[ID] [nvarchar](50) NOT NULL,
	[strPartNumber] [nvarchar](50) NOT NULL,
	[Quantity] [nvarchar](50) NOT NULL,
	[OrigQty] [money] NOT NULL,
	[Price] [decimal](18, 2) NULL,
	[Vat] [decimal](18, 2) NULL,
	[Authorised] [bit] NULL,
	[DIMSOrderDetailID] [int] NULL,
	[strComment] [nvarchar](50) NULL,
	[LineDisc] [money] NULL,
	[externalOrderId] [nvarchar](100) NULL,
 CONSTRAINT [PK_OrderLines] PRIMARY KEY CLUSTERED
(
	[ID] ASC,
	[strPartNumber] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[SalesInvoiceHeader]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[SalesInvoiceHeader](
	[BatchID] [int] NULL,
	[DocNumber] [varchar](50) NOT NULL,
	[DocDate] [varchar](50) NULL,
	[CustomerNumber] [varchar](50) NULL,
	[SoldTo1] [varchar](500) NULL,
	[SoldTo2] [varchar](500) NULL,
	[SoldTo3] [varchar](500) NULL,
	[SoldTo4] [varchar](500) NULL,
	[SoldTo5] [varchar](500) NULL,
	[ShipTo1] [varchar](500) NULL,
	[ShipTo2] [varchar](500) NULL,
	[ShipTo3] [varchar](500) NULL,
	[ShipTo4] [varchar](500) NULL,
	[ShipTo5] [varchar](500) NULL,
	[Subtotal] [money] NULL,
	[Tax] [money] NULL,
	[Total] [money] NULL,
	[intFlag] [int] NULL,
	[ErrorMessage] [nvarchar](250) NULL,
	[PushLive] [bit] NULL,
	[DIMS_OrderId] [nvarchar](50) NULL,
	[ExportType] [nvarchar](50) NULL,
	[PaymentTerms] [nvarchar](50) NULL,
	[DIMS_OrderNo] [nvarchar](50) NULL,
	[BatchReportPrinted] [bit] NULL,
	[HeaderDiscount] [nvarchar](50) NULL,
	[CompanyName] [nvarchar](50) NULL,
	[StatementStoreCode] [nvarchar](50) NULL,
	[UserDef1] [nvarchar](50) NULL,
	[JournalNumber] [bigint] NULL,
	[UserDef2] [nvarchar](50) NULL,
	[UserDef3] [nvarchar](50) NULL,
	[UserDef4] [nvarchar](50) NULL,
	[UserDef5] [nvarchar](50) NULL,
	[UserDef6] [nvarchar](50) NULL,
	[UserDef7] [nvarchar](50) NULL,
	[UserDef8] [nvarchar](50) NULL,
	[UserDef9] [nvarchar](50) NULL,
	[UserDef10] [nvarchar](50) NULL,
	[UserDef11] [nvarchar](50) NULL,
	[UserDef12] [nvarchar](50) NULL,
	[UserDef13] [nvarchar](50) NULL,
	[UserDef14] [nvarchar](50) NULL,
	[ComputerName] [nvarchar](50) NULL,
	[Printer] [nvarchar](150) NULL,
	[SupplierDocumentNumber] [nvarchar](50) NULL,
	[intSupplierFlag] [int] NULL,
	[SupplierErrorMessage] [nvarchar](255) NULL,
	[SalesmanCode] [nvarchar](50) NULL,
	[MESSAGESINV] [nvarchar](max) NULL,
	[OrderDate] [date] NULL,
	[DeliveryDate] [date] NULL,
 CONSTRAINT [PK_SalesInvoiceHeader] PRIMARY KEY CLUSTERED
(
	[DocNumber] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
/****** Object:  Table [dbo].[SalesInvoiceHeaderSource]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[SalesInvoiceHeaderSource](
	[BatchID] [int] NULL,
	[DocNumber] [varchar](50) NOT NULL,
	[DocDate] [varchar](50) NULL,
	[CustomerNumber] [varchar](50) NULL,
	[SoldTo] [varchar](500) NULL,
	[ShipTo] [varchar](500) NULL,
	[Subtotal] [money] NULL,
	[Tax] [money] NULL,
	[Total] [money] NULL,
	[intFlag] [int] NULL,
	[ErrorMessage] [nvarchar](250) NULL,
	[PushLive] [bit] NULL,
	[DIMS_OrderId] [nvarchar](50) NULL,
	[ExportType] [nvarchar](50) NULL,
	[PaymentTerms] [nvarchar](50) NULL,
	[DIMS_OrderNo] [nvarchar](50) NULL,
	[BatchReportPrinted] [bit] NULL,
	[HeaderDiscount] [nvarchar](50) NULL,
	[CompanyName] [nvarchar](50) NULL,
	[StatementStoreCode] [nvarchar](50) NULL,
	[UserDef1] [nvarchar](50) NULL,
	[JournalNumber] [bigint] NULL,
	[UserDef2] [nvarchar](50) NULL,
	[UserDef3] [nvarchar](50) NULL,
	[UserDef4] [nvarchar](50) NULL,
	[UserDef5] [nvarchar](50) NULL,
	[UserDef6] [nvarchar](50) NULL,
	[UserDef7] [nvarchar](50) NULL,
	[UserDef8] [nvarchar](50) NULL,
	[UserDef9] [nvarchar](50) NULL,
	[UserDef10] [nvarchar](50) NULL,
	[UserDef11] [nvarchar](50) NULL,
	[UserDef12] [nvarchar](50) NULL,
	[UserDef13] [nvarchar](50) NULL,
	[UserDef14] [nvarchar](50) NULL,
	[ComputerName] [nvarchar](50) NULL,
	[Printer] [nvarchar](150) NULL,
	[SupplierDocumentNumber] [nvarchar](50) NULL,
	[intSupplierFlag] [int] NULL,
	[SupplierErrorMessage] [nvarchar](255) NULL,
 CONSTRAINT [PK_SalesInvoiceHeaderSource] PRIMARY KEY CLUSTERED
(
	[DocNumber] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[SalesInvoiceLines]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[SalesInvoiceLines](
	[DocNumber] [nvarchar](50) NOT NULL,
	[PartNumber] [nvarchar](50) NOT NULL,
	[Qty] [money] NULL,
	[UnitOfMeasure] [nvarchar](50) NULL,
	[UnitPrice] [money] NULL,
	[LineTax] [money] NULL,
	[LineTotal] [money] NULL,
	[DIMS_OrderDetailId] [int] NULL,
	[PDesc] [nvarchar](250) NULL,
	[LineDiscount] [money] NULL,
	[Location] [nvarchar](50) NULL,
	[UserDef1] [nvarchar](50) NULL,
	[UserDef2] [nvarchar](50) NULL,
	[UserDef3] [nvarchar](50) NULL,
	[Comment] [nvarchar](250) NULL,
	[QtyInStock] [money] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblAccessOnCustomers]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblAccessOnCustomers](
	[intAutoGroupAccess] [int] IDENTITY(1,1) NOT NULL,
	[intGroupId] [int] NULL,
	[intUserId] [int] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblAppCompanyDetails]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblAppCompanyDetails](
	[intHtmlTagId] [bigint] IDENTITY(1,1) NOT NULL,
	[strHtmlTagName] [nvarchar](50) NULL,
	[strHtml] [nvarchar](max) NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
/****** Object:  Table [dbo].[tblAppsRoles]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblAppsRoles](
	[intRoleId] [bigint] IDENTITY(1,1) NOT NULL,
	[strRoleName] [nvarchar](250) NULL,
	[strRoleDetailDescription] [nvarchar](800) NULL,
	[strAppName] [nvarchar](50) NULL,
	[dteCreated] [datetime] NULL,
	[isRoleEnabled] [bit] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblAssociatedItems]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblAssociatedItems](
	[intAssociatedItemID] [int] NOT NULL,
	[intProductId] [int] NOT NULL,
	[intAssociatedProductId] [int] NOT NULL,
	[decQuantity] [money] NOT NULL,
 CONSTRAINT [PK_tblAssociatedItems_1] PRIMARY KEY CLUSTERED
(
	[intAssociatedItemID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblBinNames]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblBinNames](
	[intBinId] [bigint] NULL,
	[strBin] [nvarchar](50) NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblBrandOrderInvoice]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblBrandOrderInvoice](
	[BrandId] [int] NOT NULL,
	[OrderId] [int] NOT NULL,
	[OrderNo] [nvarchar](50) NULL,
	[DocNo] [nvarchar](50) NULL,
	[Changed] [bit] NOT NULL,
	[CrateDocNo] [nvarchar](50) NULL,
	[CratesIn] [float] NULL,
	[CratesOut] [float] NULL,
	[CratesActual] [float] NULL,
	[TimeIn] [datetime] NULL,
	[TimeOut] [datetime] NULL,
	[CreditIssued] [bit] NOT NULL,
	[CreditNote] [nvarchar](50) NULL,
	[mnySubTotal] [money] NULL,
	[mnyTax] [money] NULL,
	[mnyTotal] [money] NULL,
 CONSTRAINT [PK_tblBrandOrderInvoice] PRIMARY KEY CLUSTERED
(
	[BrandId] ASC,
	[OrderId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblBrands]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblBrands](
	[BrandId] [int] NOT NULL,
	[Brand] [nvarchar](50) NULL,
	[GroupId] [int] NULL,
	[NewRec] [bit] NOT NULL,
	[OwnerId] [int] NULL,
 CONSTRAINT [PK_tblBrands] PRIMARY KEY CLUSTERED
(
	[BrandId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblBreifcaseSurveyQuestions]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblBreifcaseSurveyQuestions](
	[intAuto] [bigint] IDENTITY(1,1) NOT NULL,
	[strMessage] [nvarchar](500) NULL,
	[dteActiveFrom] [date] NULL,
	[dteActiveTo] [date] NULL,
	[dtmCreate] [datetime] NULL,
	[intLocation] [int] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblBriefcaseReminders]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblBriefcaseReminders](
	[intReminderId] [bigint] IDENTITY(1,1) NOT NULL,
	[strNotes] [nvarchar](500) NULL,
	[strRemiderDaydate] [date] NULL,
	[strCustomerCode] [nvarchar](50) NULL,
	[intUserId] [int] NULL,
	[dteCreated] [datetime] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblBulkPickingSlip_Details]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblBulkPickingSlip_Details](
	[BulkPickingSlipDetailId] [int] IDENTITY(1,1) NOT NULL,
	[BulkPickingSlipHeaderId] [int] NULL,
	[ProductId] [int] NULL,
	[PriorQty] [float] NULL,
	[CurrentQty] [float] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblBulkPickingSlip_Header]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblBulkPickingSlip_Header](
	[BulkPickingSlipId] [int] IDENTITY(1,1) NOT NULL,
	[Timestamp] [datetime] NULL,
	[DeliveryDate] [datetime] NULL,
	[RouteId] [int] NULL,
	[OrderType] [int] NULL,
	[PrintedStatus] [int] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblCallistFilters]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblCallistFilters](
	[ID] [bigint] IDENTITY(1,1) NOT NULL,
	[strUserName] [nvarchar](50) NULL,
	[intUserId] [int] NULL,
	[strRouteName] [nvarchar](50) NULL,
	[intRouteId] [int] NULL,
	[intSessionUserId] [bigint] NULL,
	[dteSessionDate] [date] NULL,
 CONSTRAINT [PK_tblCallistFilters] PRIMARY KEY CLUSTERED
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblCategories]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblCategories](
	[CategoryId] [int] IDENTITY(1,1) NOT FOR REPLICATION NOT NULL,
	[Category] [nvarchar](50) NULL,
	[MainCatId] [int] NULL,
	[Discount] [float] NULL,
	[cATDiscount] [float] NULL,
	[HistoryFactorType] [int] NULL,
	[HistoryFactor] [int] NULL,
 CONSTRAINT [PK_tblCategories] PRIMARY KEY CLUSTERED
(
	[CategoryId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblCheckIn]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblCheckIn](
	[intAutoId] [bigint] IDENTITY(1,1) NOT NULL,
	[strCustCode] [nvarchar](50) NULL,
	[strAddress] [nvarchar](250) NULL,
	[strCellNumber] [nvarchar](50) NULL,
	[intAddressId] [bigint] NULL,
	[fltLat] [float] NULL,
	[fltLon] [float] NULL,
	[strLandMark] [nvarchar](250) NULL,
	[dteTimeCreated] [datetime] NULL,
	[intUserId] [int] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblClockInAndOut]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblClockInAndOut](
	[intClockInOutID] [bigint] IDENTITY(1,1) NOT NULL,
	[strUserName] [nvarchar](50) NULL,
	[strType] [nvarchar](50) NULL,
	[strCoordinates] [nvarchar](250) NULL,
	[dteSaved] [datetime] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblCommunications]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblCommunications](
	[ID] [int] IDENTITY(345340,1) NOT NULL,
	[SendTo] [nvarchar](255) NOT NULL,
	[Subject] [nvarchar](max) NULL,
	[Body] [nvarchar](max) NULL,
	[DealtWith] [bit] NULL,
	[TimeSent] [datetime] NULL,
	[Attachment] [nvarchar](255) NULL,
	[Type] [nvarchar](255) NOT NULL,
	[Response] [bit] NULL,
	[Timestamp] [datetime] NOT NULL,
 CONSTRAINT [PK_tblCommunications] PRIMARY KEY CLUSTERED
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
/****** Object:  Table [dbo].[tblCommunicationsGroups]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblCommunicationsGroups](
	[intID] [bigint] IDENTITY(1,1) NOT NULL,
	[strGroupName] [nvarchar](50) NOT NULL,
	[strWindowsUserLogin] [nvarchar](50) NOT NULL,
 CONSTRAINT [PK_tblCommunicationsGroups] PRIMARY KEY CLUSTERED
(
	[intID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblCommunicationsNetwork]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblCommunicationsNetwork](
	[intID] [bigint] IDENTITY(1,1) NOT NULL,
	[intCommunicationsID] [bigint] NOT NULL,
	[strWindowsUserLogin] [nvarchar](50) NOT NULL,
	[bitDealtWith] [bit] NOT NULL,
	[bitResponse] [bit] NOT NULL,
 CONSTRAINT [PK_tblCommunicationsNetwork] PRIMARY KEY CLUSTERED
(
	[intID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblCOMPANYREPORTS]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblCOMPANYREPORTS](
	[Company] [nvarchar](50) NULL,
	[ReportType] [nvarchar](50) NULL,
	[ReportName] [nvarchar](255) NULL,
	[Function] [nvarchar](50) NULL,
	[Comment] [nvarchar](max) NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
/****** Object:  Table [dbo].[tblCustomerDefaultOrders]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblCustomerDefaultOrders](
	[ID] [int] IDENTITY(30160,1) NOT FOR REPLICATION NOT NULL,
	[CustomerId] [int] NULL,
	[DeliveryAddressId] [int] NULL,
	[ProductId] [int] NULL,
	[Qty] [float] NULL,
	[FactorType] [int] NULL,
	[Factor] [int] NULL,
	[Avg] [float] NULL,
	[PushProduct] [bit] NULL,
	[TrendingId] [int] NULL,
	[2WeekAvg] [float] NULL,
	[InvoiceValue] [float] NULL,
 CONSTRAINT [PK_tblCustomerDefaultOrders] PRIMARY KEY CLUSTERED
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [MainKey] UNIQUE NONCLUSTERED
(
	[CustomerId] ASC,
	[DeliveryAddressId] ASC,
	[ProductId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblCustomerDefaultOrdersValue]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblCustomerDefaultOrdersValue](
	[CustomerId] [int] NULL,
	[DeliveryAddressId] [int] NULL,
	[NumberOFItems] [float] NULL,
	[FactorType] [int] NULL,
	[Factor] [int] NULL,
	[AvgInvoiceValue] [float] NULL,
	[TrendingId] [int] NULL,
	[2WeekAvg] [float] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblCustomerDeliveryAddress]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblCustomerDeliveryAddress](
	[DeliveryAddressId] [int] IDENTITY(1,1) NOT FOR REPLICATION NOT NULL,
	[CustomerId] [int] NULL,
	[DAddress1] [nvarchar](50) NULL,
	[DAddress2] [nvarchar](50) NULL,
	[DAddress3] [nvarchar](50) NULL,
	[DAddress4] [nvarchar](50) NULL,
	[DAddress5] [nvarchar](50) NULL,
	[RouteID] [int] NULL,
	[NewRec] [bit] NOT NULL,
	[DeliveryCode] [nvarchar](3) NULL,
	[DCrateAccount] [nvarchar](6) NULL,
	[DCrateContra] [nvarchar](7) NULL,
	[DCrateCharge] [int] NULL,
	[DCrates] [int] NULL,
	[DCratesVariance] [int] NULL,
	[DMonday] [bit] NOT NULL,
	[DTuesday] [bit] NOT NULL,
	[DWednesday] [bit] NOT NULL,
	[DThursday] [bit] NOT NULL,
	[DFriday] [bit] NOT NULL,
	[DSaturday] [bit] NOT NULL,
	[DSunday] [bit] NOT NULL,
	[DContactPerson] [nvarchar](50) NULL,
	[DContactTel] [nvarchar](50) NULL,
	[DCellPhone] [nvarchar](50) NULL,
	[UserID] [int] NULL,
	[SalesmanCode] [nvarchar](50) NULL,
	[strCustomerTranslation] [nvarchar](200) NULL,
	[fltLatitude] [float] NULL,
	[fltLongitude] [float] NULL,
 CONSTRAINT [PK_tblCustomerDeliveryAddress] PRIMARY KEY CLUSTERED
(
	[DeliveryAddressId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblCustomerGeoCoordinates]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblCustomerGeoCoordinates](
	[intCoordinates] [bigint] IDENTITY(1,1) NOT NULL,
	[fltLatitude] [float] NULL,
	[fltLongitude] [float] NULL,
	[strCustomerCode] [nvarchar](50) NULL,
	[dtetUpdated] [datetime] NULL,
	[intDeliveryAddressID] [int] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblCustomerNotes]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblCustomerNotes](
	[intoAutoIncrement] [bigint] IDENTITY(1,1) NOT NULL,
	[strCustomerCode] [nvarchar](50) NULL,
	[dteDate] [date] NULL,
	[dttimeRecord] [datetime] NULL,
	[strNotes] [nvarchar](500) NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblCustomers]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblCustomers](
	[CustomerId] [int] IDENTITY(1,1) NOT FOR REPLICATION NOT NULL,
	[CustomerPastelCode] [nvarchar](50) NULL,
	[GroupId] [int] NULL,
	[StoreName] [nvarchar](80) NULL,
	[AreaId] [int] NULL,
	[Routeid] [int] NULL,
	[DeliverySequence] [int] NULL,
	[PriceListId] [int] NULL,
	[Discount] [float] NULL,
	[Terms] [bit] NULL,
	[StatusId] [int] NULL,
	[ErrorRange] [float] NULL,
	[ContactTel] [nvarchar](50) NULL,
	[ContactFax] [nvarchar](50) NULL,
	[ContactPerson] [nvarchar](50) NULL,
	[Email] [nvarchar](255) NULL,
	[OtherImportantNotes] [nvarchar](max) NULL,
	[FudgeFactor] [float] NULL,
	[SuspendStandingOrder] [bit] NULL,
	[Crates] [float] NULL,
	[CratesVariance] [float] NULL,
	[PaymentTerms] [nvarchar](3) NULL,
	[Adress1] [nvarchar](30) NULL,
	[Adress2] [nvarchar](30) NULL,
	[Adress3] [nvarchar](30) NULL,
	[Adress4] [nvarchar](30) NULL,
	[Adress5] [nvarchar](30) NULL,
	[TaxExempt] [bit] NULL,
	[SettlementTems] [nvarchar](2) NULL,
	[PriceList] [nvarchar](1) NULL,
	[SalesAnalysisCode] [nvarchar](5) NULL,
	[DeliveryAddress1] [nvarchar](30) NULL,
	[DeliveryAddress2] [nvarchar](30) NULL,
	[DeliveryAddress3] [nvarchar](30) NULL,
	[DeliveryAddress4] [nvarchar](30) NULL,
	[DeliveryAddress5] [nvarchar](30) NULL,
	[Exclusive] [bit] NULL,
	[Statements] [nvarchar](1) NULL,
	[OpenItem] [bit] NULL,
	[CustomerCategory] [int] NULL,
	[CurrencyCode] [nvarchar](2) NULL,
	[CreditLimit] [nvarchar](9) NULL,
	[UserField1] [nvarchar](16) NULL,
	[UserField2] [nvarchar](16) NULL,
	[UserField3] [nvarchar](16) NULL,
	[UserField4] [nvarchar](16) NULL,
	[UserField5] [nvarchar](16) NULL,
	[MonthOrDay] [bit] NULL,
	[StatPrintOrEmail] [smallint] NULL,
	[DocPrintOrEmail] [smallint] NULL,
	[CellPhone] [nvarchar](16) NULL,
	[Freight] [nvarchar](10) NULL,
	[Ship] [nvarchar](16) NULL,
	[TimeIn] [datetime] NULL,
	[Send] [bit] NULL,
	[Monday] [bit] NULL,
	[Tueday] [bit] NULL,
	[Wednesday] [bit] NULL,
	[Thursday] [bit] NULL,
	[Friday] [bit] NULL,
	[Saturday] [bit] NULL,
	[Sunday] [bit] NULL,
	[NewSequence] [int] NULL,
	[QuoteorInvoice] [bit] NULL,
	[NewRec] [bit] NULL,
	[UniqueDelivery] [bit] NULL,
	[MultipleDeliveries] [bit] NULL,
	[CrateCharge] [int] NULL,
	[CustomerCrate] [nvarchar](50) NULL,
	[CrateContra] [nvarchar](50) NULL,
	[MondayOrderNo] [nvarchar](50) NULL,
	[TuesdayOrderNo] [nvarchar](50) NULL,
	[WednesdayOrderNo] [nvarchar](50) NULL,
	[ThursdayOrderNo] [nvarchar](50) NULL,
	[FridayOrderNo] [nvarchar](50) NULL,
	[SaturdayOrderNo] [nvarchar](50) NULL,
	[SundayOrderNo] [nvarchar](50) NULL,
	[BasicRebate] [float] NULL,
	[DoNotInvoice] [bit] NULL,
	[DoNotReturn] [bit] NULL,
	[CashOnly] [bit] NULL,
	[TaxType] [int] NULL,
	[GroupCode] [int] NULL,
	[PriceListName] [nvarchar](50) NULL,
	[Account] [bit] NULL,
	[OwnerID] [int] NULL,
	[Driver] [bit] NULL,
	[ElectronicStatementId] [int] NULL,
	[BuyerContact] [nvarchar](255) NULL,
	[BuyerTelephone] [nvarchar](255) NULL,
	[Fridge] [bit] NULL,
	[LocationID] [int] NULL,
	[UserID] [int] NULL,
	[Ageing1] [float] NULL,
	[Ageing2] [float] NULL,
	[Ageing3] [float] NULL,
	[Ageing4] [float] NULL,
	[Ageing5] [float] NULL,
	[BalanceDue] [float] NULL,
	[TaxReference] [nvarchar](50) NULL,
	[ShowCustomer] [nvarchar](1) NULL,
	[CallCycleId] [int] NULL,
	[EMailInvoice] [bit] NULL,
	[DefaultStore] [nvarchar](3) NULL,
	[MonRouteId] [int] NULL,
	[MonSeq] [int] NULL,
	[TueRouteId] [int] NULL,
	[TueSeq] [int] NULL,
	[WedRouteId] [int] NULL,
	[WedSeq] [int] NULL,
	[ThuRouteId] [int] NULL,
	[ThuSeq] [int] NULL,
	[FriRouteId] [int] NULL,
	[FriSeq] [int] NULL,
	[SatRouteId] [int] NULL,
	[SatSeq] [int] NULL,
	[SunRouteId] [int] NULL,
	[SunSeq] [int] NULL,
	[DeliveryGroupId] [int] NULL,
	[Dontsplit] [bit] NULL,
	[PriorityCustomer] [bit] NULL,
	[MarkupPercentage] [float] NULL,
	[CustomerOnHold] [bit] NULL,
	[HighOrderValue] [float] NULL,
	[bitCreditHold] [tinyint] NULL,
	[Password] [nvarchar](255) NULL,
	[strPaymentTerm] [nchar](255) NULL,
	[mnyCustomerGp] [money] NULL,
	[strDriversAppEmail] [nvarchar](500) NULL,
	[intLocationId] [int] NULL,
 CONSTRAINT [PK_tblCustomers] PRIMARY KEY CLUSTERED
(
	[CustomerId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
/****** Object:  Table [dbo].[tblCustomerSpecialHeader]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblCustomerSpecialHeader](
	[SpecialHeaderId] [int] IDENTITY(1,1) NOT NULL,
	[CustomerId] [int] NULL,
	[DateFrom] [datetime] NULL,
	[DateTo] [datetime] NULL,
	[SalesRep] [nvarchar](50) NULL,
 CONSTRAINT [PK_tblCustomerSpecialHeader] PRIMARY KEY CLUSTERED
(
	[SpecialHeaderId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblCustomerSpecials]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblCustomerSpecials](
	[CustomerSpecial] [int] IDENTITY(1,1) NOT FOR REPLICATION NOT NULL,
	[Date] [datetime] NULL,
	[DateTo] [datetime] NULL,
	[Customerid] [int] NULL,
	[ProductId] [int] NULL,
	[Price] [money] NULL,
	[NewRec] [bit] NOT NULL,
	[SpecialHeaderId] [int] NULL,
	[SpecialType] [int] NULL,
	[DiscPerc] [float] NULL,
	[BuyQty] [float] NULL,
	[QtyFree] [float] NULL,
	[FixedValue] [float] NULL,
	[CostPrice] [float] NULL,
	[DiscPerc2] [float] NULL,
	[DiscPerc3] [float] NULL,
	[DiscPerc4] [float] NULL,
	[GP] [float] NULL,
	[PriceInc] [float] NULL,
	[IncPrice] [float] NULL,
	[MarkupPercentage] [float] NULL,
 CONSTRAINT [PK_tblCustomerSpecials] PRIMARY KEY CLUSTERED
(
	[CustomerSpecial] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblCustomerSpecialTypes]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblCustomerSpecialTypes](
	[intCustomerSpecialTypeId] [int] IDENTITY(1,1) NOT FOR REPLICATION NOT NULL,
	[strCustomerSpecialType] [nvarchar](50) NOT NULL,
	[bitAllowDIMS] [bit] NOT NULL,
	[bitAllowWebstore] [bit] NOT NULL,
 CONSTRAINT [PK_tblCustomerSpecialTypes] PRIMARY KEY CLUSTERED
(
	[intCustomerSpecialTypeId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblDayBasedPTermsfromPastel]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblDayBasedPTermsfromPastel](
	[intPTCode] [int] NOT NULL,
	[intPTDays] [int] NOT NULL,
	[strPTInvPer] [nvarchar](50) NOT NULL,
 CONSTRAINT [PK_tblDayBasedPTermsfromPastel] PRIMARY KEY CLUSTERED
(
	[intPTCode] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblDeliveryAddress]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblDeliveryAddress](
	[Orderid] [int] NOT NULL,
	[DeliveryAdd1] [nvarchar](30) NULL,
	[DeliveryAdd2] [nvarchar](30) NULL,
	[DeliveryAdd3] [nvarchar](30) NULL,
	[DeliveryAdd4] [nvarchar](30) NULL,
	[DeliveryAdd5] [nvarchar](30) NULL,
	[Routeid] [int] NULL,
	[DeliveryAddressID] [int] NULL,
	[CrateAccount] [nvarchar](6) NULL,
	[LinkCustomerId] [int] NULL,
	[SalesmanCode] [nvarchar](50) NULL,
 CONSTRAINT [PK_tblDeliveryAddress] PRIMARY KEY CLUSTERED
(
	[Orderid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblDeliveryDateRouting]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblDeliveryDateRouting](
	[DeliveryDate] [datetime] NOT NULL,
	[RouteId] [int] NOT NULL,
	[OrderTypeId] [int] NOT NULL,
	[TruckId] [int] NULL,
	[DriverId] [int] NULL,
	[CratesIn] [int] NULL,
	[CratesOut] [int] NULL,
	[NewRec] [bit] NULL,
	[DeliveryDateRoutingID] [int] IDENTITY(1,1) NOT NULL,
	[AssistantId] [int] NULL,
	[Comment] [ntext] NULL,
	[LoadingStarted] [bit] NULL,
	[LoadingBy] [int] NULL,
	[Closed] [bit] NULL,
	[intDispatchId] [int] NULL,
	[dtetripsheetprintedtime] [datetime] NULL,
	[strSignature] [nvarchar](max) NULL,
	[strSignedCredit] [nvarchar](max) NULL,
	[blnVerified] [bit] NULL,
	[strCoordinateStart] [nvarchar](50) NULL,
	[strSignatureAuthStock] [nvarchar](max) NULL,
 CONSTRAINT [PK_tblDeliveryDateRouting] PRIMARY KEY CLUSTERED
(
	[DeliveryDate] ASC,
	[RouteId] ASC,
	[OrderTypeId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
/****** Object:  Table [dbo].[tblDeliveryDates]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblDeliveryDates](
	[DeliveryDateId] [int] IDENTITY(1421,1) NOT FOR REPLICATION NOT NULL,
	[OrderDateId] [int] NOT NULL,
	[DeliveryDates] [datetime] NULL,
	[Comments] [nvarchar](255) NULL,
	[InvoiceWritten] [bit] NULL,
	[NotOpenForLoading] [bit] NULL,
 CONSTRAINT [PK_tblDeliveryDates] PRIMARY KEY CLUSTERED
(
	[DeliveryDateId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblDimsBriefcaseMemos]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblDimsBriefcaseMemos](
	[intAutoId] [bigint] IDENTITY(1,1) NOT NULL,
	[intDepId] [int] NULL,
	[strDeptName] [nvarchar](50) NULL,
	[strMessage] [nvarchar](500) NULL,
	[intCreatedBy] [int] NULL,
	[intAssignedTo] [int] NULL,
	[dteTimeCreate] [datetime] NULL,
	[intStatusId] [int] NULL,
	[strSubject] [nvarchar](50) NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblDIMSConsoleTypes]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblDIMSConsoleTypes](
	[intAutoIncrement] [bigint] IDENTITY(1,1) NOT NULL,
	[intConsoleTypeID] [int] NULL,
	[strConsoleTypes] [nvarchar](50) NULL,
	[strMessage] [nvarchar](500) NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblDIMSGROUPS]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblDIMSGROUPS](
	[GroupId] [int] NULL,
	[GroupName] [nvarchar](50) NULL,
	[ExportAllOrders] [bit] NOT NULL,
	[ExportAllReturns] [bit] NOT NULL,
	[ExportOrderNow] [bit] NOT NULL,
	[Administrator] [bit] NOT NULL,
	[StatusId] [bit] NOT NULL,
	[AreaId] [int] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblDIMSGroupSetup]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblDIMSGroupSetup](
	[GroupID] [int] NOT NULL,
	[OptionDesc] [nvarchar](255) NOT NULL,
	[Selected] [bit] NOT NULL,
 CONSTRAINT [PK_tblDIMSGroupSetup] PRIMARY KEY CLUSTERED
(
	[GroupID] ASC,
	[OptionDesc] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblDIMSgroupsOptions]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblDIMSgroupsOptions](
	[Type] [int] NULL,
	[OptionDesc] [nvarchar](50) NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblDIMSUSERS]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblDIMSUSERS](
	[UserID] [int] NOT NULL,
	[PastelUser] [int] NULL,
	[StatusId] [bit] NULL,
	[UserName] [nvarchar](50) NULL,
	[Administrator] [bit] NULL,
	[Password] [nvarchar](12) NULL,
	[GroupId] [int] NULL,
	[LoggedIn] [bit] NULL,
	[Exporting] [bit] NULL,
	[exportAllOrders] [bit] NULL,
	[ExportAllReturns] [bit] NULL,
	[refreshstock] [bit] NULL,
	[DefaultRoute] [int] NULL,
	[PrinterPathInvoice] [nvarchar](255) NULL,
	[PrinterPathCreditNote] [nvarchar](255) NULL,
	[PrinterPathPickingSlip] [nvarchar](255) NULL,
	[PrinterPathSalesOrder] [nvarchar](255) NULL,
	[PrinterPathPurchaseOrder] [nvarchar](255) NULL,
	[WindowsUserLogin] [nvarchar](255) NULL,
	[TabletUser] [bit] NULL,
	[Email] [nvarchar](255) NULL,
	[ReceiveSalesBroadCasts] [bit] NULL,
	[CellPhone] [nvarchar](255) NULL,
	[RunPastelLinks] [bit] NULL,
	[UsualFEPath] [nvarchar](max) NULL,
	[ClientName] [nvarchar](255) NULL,
	[SessionId] [nvarchar](255) NULL,
	[PinCode] [float] NULL,
	[DefaultUserTransitDepotCode] [int] NULL,
	[lngDefaultOrderType] [int] NULL,
	[strSalesmanCode] [nvarchar](255) NULL,
	[strField6] [nvarchar](max) NULL,
	[remember_token] [nvarchar](max) NULL,
	[authInvoices] [bit] NULL,
	[PrinterPathTruckControl] [nvarchar](255) NULL,
	[LocationId] [int] NULL,
	[strPickingTeams] [nvarchar](50) NULL,
	[intAllowMultiLines] [int] NULL,
	[bitAllowedToSeeTruckLogs] [bit] NULL,
 CONSTRAINT [PK_tblDIMSUSERS] PRIMARY KEY CLUSTERED
(
	[UserID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
/****** Object:  Table [dbo].[tblDispatchLocations]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblDispatchLocations](
	[intAutodispatchlocations] [bigint] IDENTITY(1,1) NOT NULL,
	[strDoorName] [nvarchar](250) NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblDriverRoutes]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblDriverRoutes](
	[RouteId] [int] NULL,
	[DriverId] [int] NULL,
	[TruckId] [int] NULL,
	[AssistantId] [int] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblDrivers]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblDrivers](
	[DriverId] [int] IDENTITY(1,1) NOT FOR REPLICATION NOT NULL,
	[DriverName] [nvarchar](50) NULL,
	[InActive] [bit] NULL,
	[NewRec] [bit] NULL,
	[CustomerId] [int] NULL,
	[GLCode] [nvarchar](255) NULL,
 CONSTRAINT [PK_tblDrivers] PRIMARY KEY CLUSTERED
(
	[DriverId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblDriversAppCreditRequestHeader]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblDriversAppCreditRequestHeader](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[strCustomerName] [nvarchar](250) NULL,
	[dteDeliveryDate] [date] NULL,
	[dtePostDateTime] [datetime] NULL,
	[strDeviceReferenceId] [nvarchar](50) NULL,
	[strImage] [nvarchar](max) NULL,
	[strSignedBy] [nvarchar](50) NULL,
	[strEmail] [nvarchar](250) NULL,
	[strDriverName] [nvarchar](50) NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
/****** Object:  Table [dbo].[tblDriversAppCreditRequestLines]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblDriversAppCreditRequestLines](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[strProductName] [nvarchar](250) NULL,
	[mnyQty] [money] NULL,
	[mnyWeights] [money] NULL,
	[dtePosted] [datetime] NULL,
	[strComment] [nvarchar](500) NULL,
	[strRstrDeviceReferenceId] [nvarchar](50) NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblDriversAppTripHeader]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblDriversAppTripHeader](
	[intIdAuto] [bigint] IDENTITY(1,1) NOT NULL,
	[strSealNumber] [nvarchar](50) NULL,
	[strroutename] [nvarchar](50) NULL,
	[strordertypes] [nvarchar](50) NULL,
	[mnykmoutt] [money] NULL,
	[mnykmdone] [money] NULL,
	[strdrivername] [nvarchar](50) NULL,
	[strsignature] [nvarchar](max) NULL,
	[dteDeliveryDate] [date] NULL,
	[dtm] [datetime] NULL,
	[strDeviceID] [nvarchar](50) NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
/****** Object:  Table [dbo].[tblDriversCashOff]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblDriversCashOff](
	[Reference Number] [int] IDENTITY(1,1) NOT FOR REPLICATION NOT NULL,
	[Date] [datetime] NULL,
	[DriverId] [int] NULL,
	[TruckId] [int] NULL,
	[Expenses For Day] [float] NULL,
	[Cash on hand For Day] [float] NULL,
	[CC For Day] [float] NULL,
	[Cheq For Day] [float] NULL,
	[Cash For Day] [float] NULL,
	[Acc For Day] [float] NULL,
	[Unpaid For Day] [float] NULL,
	[Exported] [bit] NOT NULL,
	[ExportReference] [nvarchar](255) NULL,
	[GLCode] [nvarchar](50) NULL,
	[DeliveryDateRoutingID] [int] NULL,
	[GRN_Number] [nvarchar](50) NULL,
	[Message1] [nvarchar](255) NULL,
	[CustOrGL] [bit] NOT NULL,
	[User] [int] NULL,
	[TimeExported] [datetime] NULL,
	[TruckControlEntryTypeReceipts] [int] NULL,
	[TruckControlEntryTypeExpenses] [int] NULL,
	[CashControlAccount] [nvarchar](50) NULL,
	[VATControlAccount] [int] NULL,
	[Diff] [float] NULL,
	[ToBankRefId] [int] NULL,
	[JournalExport] [bit] NOT NULL,
	[JournalExportReason] [nvarchar](255) NULL,
	[BatchReportPrinted] [int] NULL,
 CONSTRAINT [PK_tblDriversCashOff] PRIMARY KEY CLUSTERED
(
	[Reference Number] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblDriversCashOffCash]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblDriversCashOffCash](
	[Reference Number] [int] NOT NULL,
	[Cash Off Ref Num] [int] IDENTITY(1,1) NOT FOR REPLICATION NOT NULL,
	[R5] [int] NULL,
	[R5 Total] [int] NULL,
	[R2] [int] NULL,
	[R2 Total] [int] NULL,
	[R1] [int] NULL,
	[R1 Total] [int] NULL,
	[50c] [int] NULL,
	[50c Total] [float] NULL,
	[20c] [int] NULL,
	[20c Total] [float] NULL,
	[10c] [int] NULL,
	[10c Total] [float] NULL,
	[5c] [int] NULL,
	[5c Total] [float] NULL,
	[2c] [int] NULL,
	[2c Total] [float] NULL,
	[1c] [int] NULL,
	[1c Total] [float] NULL,
	[200] [int] NULL,
	[200 Total] [int] NULL,
	[100] [int] NULL,
	[100 Total] [int] NULL,
	[50] [int] NULL,
	[50 Total] [int] NULL,
	[20] [int] NULL,
	[20 Total] [int] NULL,
	[10] [int] NULL,
	[10 Total] [int] NULL,
	[FreeFormTotal] [float] NULL,
	[Grand Total] [float] NULL,
	[Exported] [bit] NOT NULL,
	[ExportReference] [nvarchar](8) NULL,
 CONSTRAINT [PK_tblDriversCashOffCash] PRIMARY KEY CLUSTERED
(
	[Cash Off Ref Num] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblDriversCashoffExpenses]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblDriversCashoffExpenses](
	[Expenses Ref No] [int] IDENTITY(1,1) NOT FOR REPLICATION NOT NULL,
	[Reference Number] [int] NULL,
	[Type] [nvarchar](50) NULL,
	[GLCode] [nvarchar](50) NULL,
	[Amount] [float] NULL,
	[Default value] [int] NULL,
	[Exported] [bit] NOT NULL,
	[ExportReference] [nvarchar](8) NULL,
	[TaxId] [int] NULL,
	[JournalExport] [bit] NOT NULL,
	[JournalExportReason] [nvarchar](255) NULL,
 CONSTRAINT [PK_tblDriversCashoffExpenses] PRIMARY KEY CLUSTERED
(
	[Expenses Ref No] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblDriversCashOffInvoices]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblDriversCashOffInvoices](
	[Input Ref No] [int] IDENTITY(1,1) NOT FOR REPLICATION NOT NULL,
	[Reference Number] [int] NULL,
	[GLCode] [nvarchar](7) NULL,
	[Inv] [nvarchar](50) NULL,
	[Cash] [float] NULL,
	[EFT] [float] NULL,
	[Acc] [float] NULL,
	[Chq] [float] NULL,
	[Unpaid] [float] NULL,
	[Exported] [bit] NOT NULL,
	[ExportReference] [nvarchar](255) NULL,
	[InvoiceAmount] [float] NULL,
	[Owner] [int] NULL,
	[GRN_Number] [nvarchar](50) NULL,
	[ShortPayReason] [int] NULL,
	[AdHocID] [int] NULL,
	[CustomerId] [int] NULL,
	[NotGotPOD] [bit] NOT NULL,
	[Sequence] [int] NULL,
	[Redeliver] [bit] NOT NULL,
	[ChqNo] [nvarchar](255) NULL,
	[ChqDate] [datetime] NULL,
	[Notes] [nvarchar](255) NULL,
	[JournalExport] [bit] NOT NULL,
	[JournalExportReason] [nvarchar](255) NULL,
 CONSTRAINT [PK_tblDriversCashOffInvoices] PRIMARY KEY CLUSTERED
(
	[Input Ref No] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblExtraDriversAppProducts]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblExtraDriversAppProducts](
	[intAutoId] [bigint] IDENTITY(1,1) NOT NULL,
	[intProductId] [bigint] NULL,
	[strProductCode] [nvarchar](50) NULL,
	[strProductName] [nvarchar](250) NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblGLCodes]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblGLCodes](
	[GLId] [bigint] IDENTITY(1,1) NOT NULL,
	[GLCode] [nvarchar](50) NULL,
	[GLCodeDesc] [nvarchar](50) NULL,
	[Blocked] [bit] NOT NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblGroupBrands]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblGroupBrands](
	[BrandId] [int] NOT NULL,
	[GroupId] [int] NOT NULL,
	[NewRec] [bit] NOT NULL,
 CONSTRAINT [PK_tblGroupBrands] PRIMARY KEY CLUSTERED
(
	[BrandId] ASC,
	[GroupId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblGroups]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblGroups](
	[GroupId] [int] IDENTITY(1,1) NOT NULL,
	[GroupName] [nvarchar](50) NULL,
	[GroupCode] [int] NULL,
	[RebateAcc] [nvarchar](50) NULL,
	[RebatePercent] [float] NULL,
	[InvoiceSeperately] [bit] NOT NULL,
	[NewRec] [bit] NOT NULL,
 CONSTRAINT [PK_tblGroups] PRIMARY KEY CLUSTERED
(
	[GroupId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblGroupSpecialImport]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblGroupSpecialImport](
	[itemCode] [nvarchar](50) NULL,
	[descriptions] [nvarchar](150) NULL,
	[dteDateFrom] [date] NULL,
	[dteDateTo] [date] NULL,
	[mnyPrice] [money] NULL,
	[intGroupId] [int] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblGroupSpecialMaster]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblGroupSpecialMaster](
	[GroupSpecialId] [int] NOT NULL,
	[GroupId] [int] NOT NULL,
	[Date] [datetime] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblGroupSpecials]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblGroupSpecials](
	[SpecialGroupid] [int] IDENTITY(1,1) NOT FOR REPLICATION NOT NULL,
	[Date] [datetime] NULL,
	[DateTo] [datetime] NULL,
	[GroupId] [int] NULL,
	[ProductId] [int] NULL,
	[Price] [money] NULL,
	[NewRec] [bit] NOT NULL,
	[SpecialHeaderId] [int] NULL,
	[SpecialType] [int] NULL,
	[DiscPerc] [float] NULL,
	[BuyQty] [float] NULL,
	[QtyFree] [float] NULL,
	[FixedValue] [float] NULL,
	[CostPrice] [float] NULL,
	[DiscPerc2] [float] NULL,
	[DiscPerc3] [float] NULL,
	[DiscPerc4] [float] NULL,
	[GP] [float] NULL,
	[PriceInc] [float] NULL,
 CONSTRAINT [PK_tblGroupSpecials] PRIMARY KEY CLUSTERED
(
	[SpecialGroupid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblGroupSpecialsHeader]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblGroupSpecialsHeader](
	[SpecialHeaderId] [int] IDENTITY(1,1) NOT NULL,
	[GroupId] [int] NULL,
	[DateFrom] [datetime] NULL,
	[DateTo] [datetime] NULL,
 CONSTRAINT [PK_tblGroupSpecialsHeader] PRIMARY KEY CLUSTERED
(
	[SpecialHeaderId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblHeadersForOtherTransactions]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblHeadersForOtherTransactions](
	[OrderId] [int] IDENTITY(223506,1) NOT NULL,
	[TransactionType] [int] NULL,
	[CustomerId] [int] NULL,
	[OrderDate] [date] NULL,
	[RouteId] [int] NULL,
	[DeliverySequence] [int] NULL,
	[DeliveryDate] [date] NULL,
	[LateOrder] [int] NULL,
	[OrderNo] [nvarchar](18) NULL,
	[Invoiced] [bit] NULL,
	[InvoiceNo] [nvarchar](255) NULL,
	[Rebate] [bit] NULL,
	[RebatRef] [nvarchar](50) NULL,
	[CratesIn] [float] NULL,
	[CratesOut] [int] NULL,
	[TimeIn] [datetime] NULL,
	[TimeOut] [datetime] NULL,
	[CratesSet] [bit] NULL,
	[TimeSet] [bit] NULL,
	[StockTakeId] [int] NULL,
	[Weight] [float] NULL,
	[timestamp] [datetime] NULL,
	[LongTermCheck] [bit] NULL,
	[CratesActual] [float] NULL,
	[CratesInvoice] [nvarchar](50) NULL,
	[CreditIssued] [bit] NULL,
	[CreditNote] [nvarchar](50) NULL,
	[CratePrice] [float] NULL,
	[TaxCode] [int] NULL,
	[MotoInvoice] [nvarchar](50) NULL,
	[MotoCrateInvoice] [nvarchar](50) NULL,
	[OrderValue] [float] NULL,
	[DoNotInvoice] [bit] NULL,
	[Disc] [float] NULL,
	[CompanyInvoiceNo] [nvarchar](50) NULL,
	[CashUp] [float] NULL,
	[DeliveryAddressID] [int] NULL,
	[User] [int] NULL,
	[TimeExported] [datetime] NULL,
	[NewRec] [bit] NULL,
	[MESSAGES] [nvarchar](255) NULL,
	[MESSAGESINV] [nvarchar](255) NULL,
	[Printed] [bit] NULL,
	[PickPrinted] [bit] NULL,
	[TruckControlId] [int] NULL,
	[ReInvoice] [bit] NULL,
	[Backorder] [bit] NULL,
	[hide] [bit] NULL,
	[StandingOrder] [bit] NULL,
	[EnteredCash] [float] NULL,
	[OverrideControlAmount] [float] NULL,
	[ControlReferenceNo] [nvarchar](50) NULL,
	[ControlGLCode] [nvarchar](8) NULL,
	[Authorised] [bit] NULL,
	[ConsignmentId] [int] NULL,
	[InvoiceNoFirst] [nvarchar](50) NULL,
	[NoAssigned] [bit] NULL,
	[OrderIncValue] [float] NULL,
	[StoreCode] [nvarchar](3) NULL,
	[Selected] [bit] NULL,
	[Volume] [float] NULL,
	[OrderHasDetail] [bit] NULL,
	[Truckid] [int] NULL,
	[Driverid] [int] NULL,
	[Loaded] [bit] NULL,
	[LoadedState] [smallint] NULL,
	[DeliveryDateRoutingId_OnOpen] [int] NULL,
	[OrderLock] [bit] NULL,
	[AwaitingStock] [bit] NULL,
	[blnPicked] [bit] NULL,
	[strTransactionRawString] [nvarchar](max) NULL,
 CONSTRAINT [PK_ForOtherTransactions] PRIMARY KEY CLUSTERED
(
	[OrderId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
/****** Object:  Table [dbo].[tblImoveItReturnCodes]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblImoveItReturnCodes](
	[intReturnId] [bigint] IDENTITY(1,1) NOT NULL,
	[strReturnCode] [nvarchar](250) NULL,
	[strFullDescription] [nvarchar](250) NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblInvoicePath]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblInvoicePath](
	[inID] [bigint] IDENTITY(1,1) NOT NULL,
	[strInvoiceNo] [nvarchar](50) NOT NULL,
	[strPath] [nvarchar](500) NOT NULL,
	[dteTimeStamp] [datetime] NOT NULL,
 CONSTRAINT [PK_tblInvoicePath] PRIMARY KEY CLUSTERED
(
	[inID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblLastPricePaid]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblLastPricePaid](
	[CustomerId] [int] NULL,
	[DeliveryDate] [datetime] NULL,
	[ProductId] [int] NULL,
	[Price] [float] NULL,
	[lngID] [int] IDENTITY(1,1) NOT FOR REPLICATION NOT NULL,
 CONSTRAINT [PK_tblLastPricePaid] PRIMARY KEY CLUSTERED
(
	[lngID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblLastTripCoordinates]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblLastTripCoordinates](
	[IdAuto] [bigint] IDENTITY(1,1) NOT NULL,
	[strLatLng] [nvarchar](50) NULL,
	[dteDateTime] [datetime] NULL,
	[dteDeliveryDate] [date] NULL,
	[strRouteName] [nvarchar](50) NULL,
	[strOrdertype] [nvarchar](50) NULL,
	[strUserName] [nvarchar](50) NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblLinxHtmlReport]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblLinxHtmlReport](
	[intAutoReportID] [bigint] IDENTITY(1,1) NOT NULL,
	[strHtmlHeader] [nvarchar](max) NULL,
	[strFormName] [nvarchar](250) NULL,
	[dtm] [datetime] NULL,
	[intOwnerID] [bigint] NULL,
	[strHtmlFooter] [nvarchar](max) NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
/****** Object:  Table [dbo].[tblLocations]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblLocations](
	[ID] [bigint] IDENTITY(1,1) NOT NULL,
	[locationName] [nvarchar](50) NULL,
	[Warehouse] [nvarchar](50) NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblMainCategories]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblMainCategories](
	[MainCatId] [int] NOT NULL,
	[MainCategory] [nvarchar](50) NULL,
	[PlanningDate] [int] NULL,
 CONSTRAINT [PK_tblMainCategories] PRIMARY KEY CLUSTERED
(
	[MainCatId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblManagementConsol]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblManagementConsol](
	[MessageId] [int] IDENTITY(4343413,1) NOT NULL,
	[ConsoleTypeId] [int] NULL,
	[Importance] [int] NULL,
	[dtm] [datetime] NULL,
	[LoggedBy] [nvarchar](50) NULL,
	[Message] [nvarchar](255) NULL,
	[Reviewed] [bit] NULL,
	[productid] [int] NULL,
	[CustomerId] [int] NULL,
	[UserId] [int] NULL,
	[ConsoleDate] [datetime] NULL,
	[OldQty] [float] NULL,
	[NewQty] [float] NULL,
	[OldPrice] [float] NULL,
	[NewPrice] [float] NULL,
	[ReviewedUserId] [int] NULL,
	[ReferenceNo] [nvarchar](50) NULL,
	[DocType] [int] NULL,
	[DocNumber] [int] NULL,
	[Computer] [nvarchar](255) NULL,
	[OrderId] [int] NULL,
	[ReturnId] [int] NULL,
 CONSTRAINT [PK_tblManagementConsol] PRIMARY KEY CLUSTERED
(
	[MessageId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblMultiStore]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblMultiStore](
	[Code] [nvarchar](3) NULL,
	[Description] [nvarchar](50) NULL,
	[DefaultStkGroup] [nvarchar](3) NULL,
	[PostalAddress1] [nvarchar](50) NULL,
	[PostalAddress2] [nvarchar](50) NULL,
	[PostalAddress3] [nvarchar](50) NULL,
	[PostalAddress4] [nvarchar](50) NULL,
	[PostalAddress5] [nvarchar](50) NULL,
	[PhysicalAddress1] [nvarchar](50) NULL,
	[PhysicalAddress2] [nvarchar](50) NULL,
	[PhysicalAddress3] [nvarchar](50) NULL,
	[PhysicalAddress4] [nvarchar](50) NULL,
	[PhysicalAddress5] [nvarchar](50) NULL,
	[Contact] [nvarchar](50) NULL,
	[Telephone] [nvarchar](50) NULL,
	[Fax] [nvarchar](50) NULL,
	[Email] [nvarchar](50) NULL,
	[Cellphone] [nvarchar](50) NULL,
	[Blocked] [bit] NOT NULL,
	[ReadStock] [bit] NOT NULL,
	[OwnerId] [int] NULL,
	[MainStore] [bit] NOT NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblMultiStoreTrn]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblMultiStoreTrn](
	[StoreCode] [nvarchar](3) NULL,
	[ItemCode] [nvarchar](50) NULL,
	[Group] [nvarchar](50) NULL,
	[LastCost] [float] NULL,
	[AvgCost] [float] NULL,
	[Onhand] [float] NULL,
	[OwnerId] [int] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblNoStockItems]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblNoStockItems](
	[intAutoIdSend] [bigint] IDENTITY(1,1) NOT NULL,
	[intProductID] [int] NULL,
	[strPastelDescription] [nvarchar](250) NULL,
	[intOrderTypeId] [int] NULL,
	[intRouteId] [int] NULL,
	[dteDeliveryDate] [date] NULL,
	[strPickerName] [nvarchar](50) NULL,
	[dtDateLasteSent] [datetime] NULL,
	[decQtyPicked] [decimal](18, 2) NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblNotiFicationsCreated]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblNotiFicationsCreated](
	[intRouteId] [int] NULL,
	[intOType] [int] NULL,
	[dDelDate] [date] NULL,
	[dtCreation] [datetime] NULL,
	[blnAttended] [bit] NULL,
	[dtAddOnTime] [datetime] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblOpenItemForAge]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblOpenItemForAge](
	[strCustCode] [nvarchar](50) NOT NULL,
	[strMatchRef] [nvarchar](50) NULL,
	[strRef] [nvarchar](50) NULL,
	[decAmount] [money] NULL,
	[dteDocDate] [date] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblOrderDates]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblOrderDates](
	[OrderDateId] [int] IDENTITY(1,1) NOT NULL,
	[OrderDate] [datetime] NULL,
	[NotifyCustomers] [bit] NOT NULL,
	[NoticePeriod] [float] NULL,
	[Notice] [nvarchar](255) NULL,
	[UseSpecialNotice] [bit] NOT NULL,
	[SpecialNotice] [nvarchar](255) NULL,
	[OrderingClosed] [bit] NOT NULL,
 CONSTRAINT [PK_tblOrderDates] PRIMARY KEY CLUSTERED
(
	[OrderDateId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblOrderDetails]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblOrderDetails](
	[OrderDetailId] [int] IDENTITY(706654,1) NOT NULL,
	[OrderId] [int] NULL,
	[ProductId] [int] NULL,
	[Qty] [float] NULL,
	[StandingOrder] [bit] NULL,
	[StockTakeDetailId] [int] NULL,
	[RebateNo] [nvarchar](50) NULL,
	[StockTakeLinkID] [int] NULL,
	[Printed] [bit] NULL,
	[QtyPrinted] [float] NULL,
	[timestamp] [datetime] NULL,
	[RangeIdOLD] [int] NULL,
	[QtyOrdered] [float] NULL,
	[Price] [float] NULL,
	[CratesQty] [float] NULL,
	[LineDisc] [float] NULL,
	[RangeId] [float] NULL,
	[CostPerUnit] [float] NULL,
	[CheckedOut] [bit] NULL,
	[FreeQty] [float] NULL,
	[DetailsDiscount] [float] NULL,
	[TaxId] [int] NULL,
	[CostPrice] [float] NULL,
	[CustomerSpecialFreeId] [int] NULL,
	[GroupSpecialFreeId] [int] NULL,
	[BuyQty] [float] NULL,
	[GetFreeQty] [float] NULL,
	[DispatchQty] [float] NULL,
	[DispatchPrice] [money] NULL,
	[OverallSpecialFreeid] [int] NULL,
	[OtyWeight] [float] NULL,
	[LineDisc2] [float] NULL,
	[LineDisc3] [float] NULL,
	[LineDisc4] [float] NULL,
	[VolumeDisc] [float] NULL,
	[FixedValue] [float] NULL,
	[NettPrice] [float] NULL,
	[Comment] [nvarchar](50) NULL,
	[UnitCount] [float] NULL,
	[VolumeDiscountType] [int] NULL,
	[Authorised] [bit] NULL,
	[StoreCode] [nvarchar](3) NULL,
	[OldFreeQty] [float] NULL,
	[IncPrice] [float] NULL,
	[Vat] [float] NULL,
	[IncNettPrice] [float] NULL,
	[ConsignmentNo] [nvarchar](8) NULL,
	[QtyWeight] [float] NULL,
	[Loaded] [bit] NULL,
	[blnPicked] [bit] NULL,
	[fltQtyPicked] [bit] NULL,
	[intLocationId] [int] NULL,
	[intHiddenToken] [bigint] NULL,
	[returnQty] [money] NULL,
	[offLoadComment] [nvarchar](500) NULL,
	[blnOffLoadedDriver] [bit] NULL,
	[strCustomerReason] [nvarchar](500) NULL,
	[intQueueId] [bigint] NULL,
	[mnyQtyRemaining] [money] NULL,
	[blnCostAuth] [bit] NULL,
	[dteLineRequisition] [datetime] NULL,
	[scannedQty] [money] NULL,
 CONSTRAINT [PK_tblOrderDetails] PRIMARY KEY CLUSTERED
(
	[OrderDetailId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblOrderDetailsForOtherTransactions]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblOrderDetailsForOtherTransactions](
	[OrderDetailId] [int] IDENTITY(1,1) NOT NULL,
	[OrderId] [int] NULL,
	[ProductId] [int] NULL,
	[Qty] [float] NULL,
	[StandingOrder] [bit] NOT NULL,
	[StockTakeDetailId] [int] NULL,
	[RebateNo] [nvarchar](50) NULL,
	[StockTakeLinkID] [int] NULL,
	[Printed] [bit] NOT NULL,
	[QtyPrinted] [float] NULL,
	[timestamp] [datetime] NULL,
	[RangeIdOLD] [int] NULL,
	[QtyOrdered] [float] NULL,
	[Price] [float] NULL,
	[CratesQty] [float] NULL,
	[LineDisc] [float] NULL,
	[RangeId] [float] NULL,
	[CostPerUnit] [float] NULL,
	[CheckedOut] [bit] NOT NULL,
	[FreeQty] [float] NULL,
	[DetailsDiscount] [float] NULL,
	[TaxId] [int] NULL,
	[CostPrice] [float] NULL,
	[CustomerSpecialFreeId] [int] NULL,
	[GroupSpecialFreeId] [int] NULL,
	[BuyQty] [float] NULL,
	[GetFreeQty] [float] NULL,
	[DispatchQty] [float] NULL,
	[OverallSpecialFreeid] [int] NULL,
	[OtyWeight] [float] NULL,
	[Comment] [nvarchar](50) NULL,
	[LineDisc2] [float] NULL,
	[LineDisc3] [float] NULL,
	[LineDisc4] [float] NULL,
	[VolumeDisc] [float] NULL,
	[FixedValue] [float] NULL,
	[NettPrice] [float] NULL,
	[UnitCount] [float] NULL,
	[VolumeDiscountType] [int] NULL,
	[Authorised] [bit] NOT NULL,
	[ConsignmentNo] [nvarchar](8) NULL,
	[StoreCode] [nvarchar](3) NULL,
	[OldFreeQty] [float] NULL,
	[IncPrice] [float] NULL,
	[Vat] [float] NULL,
	[IncNettPrice] [float] NULL,
	[PriceInc] [float] NULL,
	[QtyTrimFlag] [bit] NOT NULL,
	[Loaded] [bit] NULL,
	[blnPicked] [bit] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblOrderLocks]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblOrderLocks](
	[OrderId] [int] NOT NULL,
	[UserId] [int] NOT NULL,
	[TimeStamp] [datetime] NULL,
 CONSTRAINT [PK_tblOrderLocks] PRIMARY KEY CLUSTERED
(
	[OrderId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblOrderLocksByDepartment]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblOrderLocksByDepartment](
	[intOrderID] [int] NOT NULL,
	[strDepartment] [nvarchar](50) NOT NULL,
	[intUserID] [int] NULL,
 CONSTRAINT [PK_tblOrderLocksByDepartment] PRIMARY KEY CLUSTERED
(
	[intOrderID] ASC,
	[strDepartment] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblOrders]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblOrders](
	[OrderId] [int] IDENTITY(10000,1) NOT NULL,
	[CustomerId] [int] NULL,
	[OrderDate] [datetime] NULL,
	[RouteId] [int] NULL,
	[DeliverySequence] [int] NULL,
	[DeliveryDate] [datetime] NULL,
	[LateOrder] [int] NULL,
	[OrderNo] [nvarchar](25) NULL,
	[Invoiced] [bit] NULL,
	[InvoiceNo] [nvarchar](255) NULL,
	[Rebate] [bit] NULL,
	[RebatRef] [nvarchar](50) NULL,
	[CratesIn] [float] NULL,
	[CratesOut] [int] NULL,
	[TimeIn] [datetime] NULL,
	[TimeOut] [datetime] NULL,
	[CratesSet] [bit] NULL,
	[TimeSet] [bit] NULL,
	[StockTakeId] [int] NULL,
	[Weight] [float] NULL,
	[timestamp] [datetime] NULL,
	[LongTermCheck] [bit] NULL,
	[CratesActual] [float] NULL,
	[CratesInvoice] [nvarchar](50) NULL,
	[CreditIssued] [bit] NULL,
	[CreditNote] [nvarchar](50) NULL,
	[CratePrice] [float] NULL,
	[TaxCode] [int] NULL,
	[MotoInvoice] [nvarchar](50) NULL,
	[MotoCrateInvoice] [nvarchar](50) NULL,
	[OrderValue] [float] NULL,
	[DoNotInvoice] [bit] NULL,
	[Disc] [float] NULL,
	[CompanyInvoiceNo] [nvarchar](50) NULL,
	[CashUp] [float] NULL,
	[DeliveryAddressID] [int] NULL,
	[User] [int] NULL,
	[TimeExported] [datetime] NULL,
	[NewRec] [bit] NULL,
	[MESSAGES] [nvarchar](255) NULL,
	[MESSAGESINV] [nvarchar](255) NULL,
	[Printed] [bit] NULL,
	[PickPrinted] [bit] NULL,
	[TruckControlId] [int] NULL,
	[ReInvoice] [bit] NULL,
	[Backorder] [bit] NULL,
	[hide] [bit] NULL,
	[StandingOrder] [bit] NULL,
	[EnteredCash] [float] NULL,
	[OverrideControlAmount] [float] NULL,
	[ControlReferenceNo] [nvarchar](50) NULL,
	[ControlGLCode] [nvarchar](8) NULL,
	[Authorised] [bit] NULL,
	[ConsignmentId] [int] NULL,
	[InvoiceNoFirst] [nvarchar](50) NULL,
	[NoAssigned] [bit] NULL,
	[OrderIncValue] [float] NULL,
	[StoreCode] [nvarchar](3) NULL,
	[Selected] [bit] NULL,
	[Volume] [float] NULL,
	[OrderHasDetail] [bit] NULL,
	[Truckid] [int] NULL,
	[Driverid] [int] NULL,
	[Loaded] [bit] NULL,
	[LoadedState] [smallint] NULL,
	[DeliveryDateRoutingId_OnOpen] [int] NULL,
	[OrderLock] [bit] NULL,
	[AwaitingStock] [bit] NULL,
	[blnProcessed] [bit] NULL,
	[blnPicked] [bit] NULL,
	[strPickedBy] [nvarchar](50) NULL,
	[strLoadedBy'] [nvarchar](50) NULL,
	[strStatus] [nvarchar](50) NULL,
	[blnPriority] [bit] NULL,
	[strLoadedBy] [nvarchar](50) NULL,
	[tmOrderCollectedFromPrinter] [datetime] NULL,
	[blnBackOrderSent] [bit] NULL,
	[TreatAsQuotation] [bit] NOT NULL,
	[blnCreditLimitNotificationSent] [bit] NOT NULL,
	[offloaded] [bit] NULL,
	[strImage] [nvarchar](max) NULL,
	[strNotesDrivers] [nvarchar](max) NULL,
	[mnyDriverCash] [money] NULL,
	[strEmailCustomer] [nvarchar](500) NULL,
	[strCashsignature] [nvarchar](max) NULL,
	[strSignedCredits] [nvarchar](max) NULL,
	[dtTimeTripStart] [datetime] NULL,
	[dtTimeTripEnd] [datetime] NULL,
	[strCoordinateStart] [nvarchar](500) NULL,
	[strOrderContactEmail] [nvarchar](200) NULL,
	[strOrderContactCell] [nvarchar](50) NULL,
	[strOrderContactName] [nvarchar](200) NULL,
	[bitEmailSentToCustomerAfterLoading] [bit] NULL,
	[strCustomerSignedBy] [nvarchar](250) NULL,
	[strCoordinatePost] [nvarchar](500) NULL,
	[dtimeTripStart] [datetime] NULL,
	[dtimeTripEnd] [datetime] NULL,
	[dteOffloadedTime] [datetime] NULL,
	[TreatAsQuote] [bit] NULL,
	[strEmailMappedToTheAccount] [nvarchar](500) NULL,
	[intSpecialOrder] [int] NULL,
	[strRouteTruck] [nvarchar](250) NULL,
	[fridgetemp] [money] NULL,
	[blnDeliveryNotePrinted] [bit] NOT NULL,
 CONSTRAINT [PK_tblOrders] PRIMARY KEY CLUSTERED
(
	[OrderId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
/****** Object:  Table [dbo].[tblOrderSalesCodes]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblOrderSalesCodes](
	[OrderId] [int] NULL,
	[SalesCode] [nvarchar](50) NULL,
	[DriverDeliveryDate] [datetime] NULL,
	[OrderCancelled] [bit] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblOrdersPickedSinceLastCheck]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblOrdersPickedSinceLastCheck](
	[intOrderId] [int] NOT NULL,
	[dteTimeStamp] [datetime] NOT NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblOrderTypes]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblOrderTypes](
	[OrderTypeId] [int] IDENTITY(1,1) NOT NULL,
	[OrderType] [nvarchar](50) NULL,
 CONSTRAINT [PK_tblOrderTypes] PRIMARY KEY CLUSTERED
(
	[OrderTypeId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblOverallSpecials]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblOverallSpecials](
	[Specialid] [int] IDENTITY(1,1) NOT FOR REPLICATION NOT NULL,
	[ProductId] [int] NULL,
	[Date] [datetime] NULL,
	[Dateto] [datetime] NULL,
	[Price] [float] NULL,
	[SpecialType] [int] NULL,
	[DiscPerc] [float] NULL,
	[BuyQty] [float] NULL,
	[QtyFree] [float] NULL,
	[FixedValue] [float] NULL,
	[CostPrice] [float] NULL,
	[SpecialHeaderId] [int] NULL,
	[DiscPerc2] [float] NULL,
	[DiscPerc3] [float] NULL,
	[DiscPerc4] [float] NULL,
	[GP] [float] NULL,
	[PriceInc] [float] NULL,
	[intLocationId] [int] NULL,
 CONSTRAINT [PK_tblOverallSpecials] PRIMARY KEY CLUSTERED
(
	[Specialid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblOverallSpecialsHeader]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblOverallSpecialsHeader](
	[SpecialHeaderId] [int] IDENTITY(1,1) NOT FOR REPLICATION NOT NULL,
	[DateFrom] [datetime] NULL,
	[DateTo] [datetime] NULL,
 CONSTRAINT [PK_tblOverallSpecialsHeader] PRIMARY KEY CLUSTERED
(
	[SpecialHeaderId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblOverallSpecialTypes]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblOverallSpecialTypes](
	[intOverallSpecialTypeId] [int] IDENTITY(1,1) NOT FOR REPLICATION NOT NULL,
	[strOverallSpecialType] [nvarchar](50) NOT NULL,
	[bitAllowDIMS] [bit] NOT NULL,
	[bitAllowWebstore] [bit] NOT NULL,
 CONSTRAINT [PK_tblOverallSpecialTypes] PRIMARY KEY CLUSTERED
(
	[intOverallSpecialTypeId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblOwners]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblOwners](
	[OwnerID] [int] NOT NULL,
	[CompanyName] [nvarchar](50) NULL,
	[Path] [nvarchar](50) NULL,
	[InvoiceNo] [int] NULL,
	[QuoteNo] [int] NULL,
	[CustomerID] [int] NULL,
	[DoNotList] [bit] NOT NULL,
	[ExportToPastel] [bit] NOT NULL,
	[Email] [nvarchar](50) NULL,
	[DefaultOwner] [bit] NOT NULL,
	[CustomerIdForStock] [int] NULL,
	[SupplierIdForStock] [int] NULL,
	[intCreditNo] [int] NULL,
	[strPrefixInv] [nvarchar](50) NULL,
	[strPreFixCr] [nvarchar](50) NULL,
	[bitCustomerOwner] [bit] NOT NULL,
	[bitStockOwner] [bit] NOT NULL,
	[strPreFixSupplierInv] [nvarchar](10) NULL,
	[intSupplierInvoiceNo] [int] NULL,
	[strVendName] [nvarchar](30) NULL,
	[strSalesQuoteReportPath] [nvarchar](150) NULL,
	[strInvoiceODBC] [nvarchar](50) NULL,
	[strInvoiceReportPath] [nvarchar](200) NULL,
	[strDefaultPrinterPathInvoice] [nvarchar](200) NULL,
	[bitForceUpdatePricing] [bit] NOT NULL,
	[strInvoicePastelPath] [nvarchar](100) NULL,
	[strTruckExpensesContra] [nvarchar](50) NULL,
	[intTruckControlEntryTypeReceipts] [int] NULL,
	[strEmailInvoicesAfterLoadingReportPath] [nvarchar](250) NULL,
	[strA4InvoiceReportPath] [nvarchar](250) NULL,
	[strDeliveryNoteReportPath] [nvarchar](250) NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblParameters]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblParameters](
	[DataPath] [nvarchar](255) NULL,
	[InvoiceNo] [int] NULL,
	[QuoteNo] [int] NULL,
	[PS] [nvarchar](50) NULL,
	[DEPOTPath] [nvarchar](50) NULL,
	[DDFPath] [nvarchar](255) NULL,
	[IMPORTPath] [nvarchar](50) NULL,
	[BACKUPPath] [nvarchar](50) NULL,
	[GLDepot] [nvarchar](50) NULL,
	[DepotRef] [int] NULL,
	[SiteRef] [int] NULL,
	[BACKUPPATH2] [nvarchar](255) NULL,
	[FridgeRef] [int] NULL,
	[CreditNo] [int] NULL,
	[TruckDocType] [int] NULL,
	[TruckRefNo] [int] NULL,
	[ReceiptDocType] [int] NULL,
	[GeneralDocType] [int] NULL,
	[DeliveryDate] [datetime] NULL,
	[PrintingInvoice] [bit] NOT NULL,
	[PONo] [int] NULL,
	[DriversPath] [nvarchar](255) NULL,
	[DefaultRoute] [int] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblPaymentTerms]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblPaymentTerms](
	[idAutopaymentTermId] [bigint] IDENTITY(1,1) NOT NULL,
	[intPaymentTerms] [int] NULL,
	[strPaymentTerms] [nvarchar](50) NULL,
	[bitMonthOrDay] [bit] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblPickedQtyTablets]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblPickedQtyTablets](
	[intAuto] [bigint] IDENTITY(1,1) NOT NULL,
	[mnyPickedQuantity] [money] NULL,
	[intProduct] [bigint] NOT NULL,
	[intUserID] [int] NULL,
	[dteDelDate] [date] NOT NULL,
	[intRouteID] [int] NOT NULL,
	[intOrderType] [int] NULL,
	[dteTime] [datetime] NOT NULL,
 CONSTRAINT [PK_tblPickedQtyTablets] PRIMARY KEY CLUSTERED
(
	[intAuto] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblPickingAppCases]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblPickingAppCases](
	[intAutoId] [bigint] IDENTITY(1,1) NOT NULL,
	[strPickingTypeCases] [nvarchar](50) NULL,
	[dteCreated] [datetime] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblPickingDepartments]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblPickingDepartments](
	[departmentID] [int] IDENTITY(1,1) NOT NULL,
	[strDepartment] [nvarchar](50) NULL,
	[intWareHouseId] [int] NULL,
 CONSTRAINT [PK_tblPickingDepartments] PRIMARY KEY CLUSTERED
(
	[departmentID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblPickingTeams]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblPickingTeams](
	[PickingTeamId] [int] IDENTITY(1,1) NOT NULL,
	[PickingTeam] [nvarchar](50) NULL,
	[Commision] [float] NULL,
	[PickingSlipPath] [nvarchar](255) NULL,
	[departmentID] [int] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblPriceListLines]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblPriceListLines](
	[ProductId] [int] NOT NULL,
	[PriceListUsedId] [int] NOT NULL,
	[Price] [float] NULL,
	[NewRec] [bit] NOT NULL,
	[PriceInc] [float] NULL,
	[dteTimeCreated] [datetime] NULL,
 CONSTRAINT [PK_tblPriceListLines] PRIMARY KEY CLUSTERED
(
	[ProductId] ASC,
	[PriceListUsedId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblPriceLists]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblPriceLists](
	[PriceListId] [int] NOT NULL,
	[PriceList] [nvarchar](50) NULL,
	[GroupId] [int] NULL,
	[StatusId] [int] NULL,
	[NewRec] [bit] NOT NULL,
	[MarkUp] [float] NULL,
	[brandId] [int] NULL,
 CONSTRAINT [PK_tblPriceLists] PRIMARY KEY CLUSTERED
(
	[PriceListId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblPriceListUsed]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblPriceListUsed](
	[PriceListUsedId] [int] NOT NULL,
	[PriceListId] [int] NULL,
	[Date] [datetime] NULL,
	[Explanation] [nvarchar](255) NULL,
	[NewRec] [bit] NOT NULL,
 CONSTRAINT [PK_tblPriceListUsed] PRIMARY KEY CLUSTERED
(
	[PriceListUsedId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblPriceListUsedold]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblPriceListUsedold](
	[PriceListUsedId] [int] NOT NULL,
	[PriceListId] [int] NULL,
	[Date] [datetime] NULL,
	[Explanation] [nvarchar](255) NULL,
	[NewRec] [bit] NOT NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblPrintedDocuments]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblPrintedDocuments](
	[ID] [int] IDENTITY(222522,1) NOT NULL,
	[DocumentType] [int] NULL,
	[DocId] [int] NULL,
	[User] [int] NULL,
	[TimePrinted] [datetime] NULL,
	[Printed] [bit] NULL,
	[PrinterPath] [nvarchar](255) NULL,
	[PrintDeliveryNote] [bit] NULL,
	[Attempted] [int] NULL,
 CONSTRAINT [PK_tblPrintedDocuments] PRIMARY KEY CLUSTERED
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblPrintedDocumentsFiles]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblPrintedDocumentsFiles](
	[intID] [int] IDENTITY(1,1) NOT NULL,
	[strDocumentType] [nvarchar](50) NOT NULL,
	[strDocNumber] [nvarchar](50) NOT NULL,
	[imgPDF] [varbinary](max) NULL,
	[strFileName] [nvarchar](500) NULL,
	[dteTimeStamp] [datetime] NOT NULL,
 CONSTRAINT [PK_tblPrintedDocumentsFiles] PRIMARY KEY CLUSTERED
(
	[intID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
/****** Object:  Table [dbo].[tblPrintedPicking]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblPrintedPicking](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[DocType] [int] NOT NULL,
	[DocId] [int] NULL,
	[DocDateTime] [datetime] NULL,
	[RouteId] [int] NULL,
	[LateOrder] [int] NULL,
	[Timestamp] [datetime] NOT NULL,
	[UserId] [int] NOT NULL,
	[PrinterPath] [nvarchar](200) NULL,
	[Attempted] [int] NOT NULL,
 CONSTRAINT [PK_tblPrintedBulkPicking] PRIMARY KEY CLUSTERED
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblPrinters]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblPrinters](
	[ID] [bigint] IDENTITY(1,1) NOT NULL,
	[strPrinter] [nvarchar](500) NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblProduct_Prohibit]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblProduct_Prohibit](
	[CustomerId] [int] NULL,
	[ProductId] [int] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblProduct_Push]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblProduct_Push](
	[CustomerId] [int] NULL,
	[ProductId] [int] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblProducts]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblProducts](
	[ProductId] [int] IDENTITY(1,1) NOT FOR REPLICATION NOT NULL,
	[PastelCode] [nvarchar](50) NULL,
	[PastelGroup] [nvarchar](3) NULL,
	[BrandId] [int] NULL,
	[CategoryId] [int] NULL,
	[VariantId] [int] NULL,
	[SizeId] [int] NULL,
	[PackagingId] [int] NULL,
	[Size] [float] NULL,
	[Mass] [float] NULL,
	[VolumeMilk] [float] NULL,
	[CrateId] [int] NULL,
	[PerCrate] [float] NULL,
	[TaxId] [int] NULL,
	[StatusId] [int] NULL,
	[ErrorRange] [float] NULL,
	[DisableShortage] [bit] NULL,
	[MinimiumUnitRun] [float] NULL,
	[MinimiumStockQty] [float] NULL,
	[StockTolerance] [float] NULL,
	[OrdinalPosition] [float] NULL,
	[LinkProductId] [int] NULL,
	[DaystoEnjoy] [float] NULL,
	[ProducedByDate] [datetime] NULL,
	[Produced] [float] NULL,
	[ReturnByDate] [datetime] NULL,
	[Returned] [float] NULL,
	[DaysSinceLastStock] [int] NULL,
	[StockTakeId] [int] NULL,
	[ClosingBal] [float] NULL,
	[Ordered1] [int] NULL,
	[Orders1] [int] NULL,
	[DeListOrder] [bit] NULL,
	[ListedProduct] [bit] NULL,
	[LoadOrder] [int] NULL,
	[DarkLine] [bit] NULL,
	[EnjoyByDate] [datetime] NULL,
	[BarCode] [nvarchar](15) NULL,
	[PastelDescription] [nvarchar](80) NULL,
	[TurnOnEBD] [bit] NULL,
	[WeeklyProduction] [bit] NULL,
	[SupplierProductCode] [nvarchar](15) NULL,
	[SupplierCode] [nvarchar](6) NULL,
	[MinOrderLevel] [float] NULL,
	[MinOrderQty] [float] NULL,
	[StockDescription] [nvarchar](24) NULL,
	[Conversion] [float] NULL,
	[PhysicalItem] [bit] NULL,
	[FixedDescription] [bit] NULL,
	[MaxDays] [float] NULL,
	[MinDays] [float] NULL,
	[NewRec] [bit] NULL,
	[PastelCategory] [nvarchar](50) NULL,
	[OrderReSequence] [int] NULL,
	[AYR] [bit] NULL,
	[ProductionPerCrate] [int] NULL,
	[PickingTeamId] [int] NULL,
	[StockManagement] [bit] NULL,
	[UnitsPerPack] [float] NULL,
	[Binnumber] [nvarchar](50) NULL,
	[UnitSize] [nvarchar](50) NULL,
	[LastCost] [float] NULL,
	[HistoryFactor] [int] NULL,
	[HistoryFactorType] [int] NULL,
	[UnitOfSale] [float] NULL,
	[UserField1] [nvarchar](50) NULL,
	[UserField2] [nvarchar](50) NULL,
	[UserField3] [nvarchar](50) NULL,
	[UserField4] [float] NULL,
	[UserField5] [float] NULL,
	[UserField6] [float] NULL,
	[UnitWeight] [float] NULL,
	[Consignment] [bit] NULL,
	[Perc1] [float] NULL,
	[Perc2] [float] NULL,
	[LastCostConsignment] [bit] NULL,
	[OwnerId] [int] NULL,
	[MultiLineItem] [bit] NULL,
	[SoldByWeight] [bit] NULL,
	[Productbrandid] [int] NULL,
	[PriceManagement] [bit] NULL,
	[ProductMargin] [float] NULL,
	[ManageCosts] [bit] NULL,
	[PriorityProduct] [bit] NULL,
	[AllowZeroPrice] [bit] NULL,
	[CommodityCode] [nvarchar](255) NULL,
	[strBulkUnit] [nvarchar](255) NULL,
	[bitIsWebstoreItem] [bit] NOT NULL,
	[strWebstoreDescription] [nvarchar](200) NULL,
	[bitAllowDiscount] [bit] NOT NULL,
 CONSTRAINT [PK_tblProducts] PRIMARY KEY CLUSTERED
(
	[ProductId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblReceivedTransferLines]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblReceivedTransferLines](
	[OrderID] [nvarchar](250) NULL,
	[OderDetailID] [int] NULL,
	[strTransferNo] [nvarchar](50) NULL,
	[PastelDescription] [nvarchar](50) NULL,
	[Barcode] [nvarchar](50) NULL,
	[QtyScanned] [decimal](9, 2) NULL,
	[UnitCost] [decimal](9, 2) NULL,
	[Binnumber] [nvarchar](50) NULL,
	[strProdCode] [nvarchar](50) NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblReturnDetails]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblReturnDetails](
	[ReturnDetailsId] [int] IDENTITY(14614,1) NOT NULL,
	[ReturnId] [int] NULL,
	[ProductId] [int] NULL,
	[Qty] [float] NULL,
	[EnjoyByDate] [datetime] NULL,
	[StockTakeLinkID] [int] NULL,
	[SoldDate] [datetime] NULL,
	[ReturnTypeId] [int] NULL,
	[InvoiceId] [int] NULL,
	[UnitPrice] [float] NULL,
	[LineDisc] [float] NULL,
	[ActualPrice] [float] NULL,
	[ActualQty] [float] NULL,
	[CostPerUnit] [float] NULL,
	[Discount] [float] NULL,
	[TaxId] [int] NULL,
	[LineExported] [bit] NULL,
	[Comment] [nvarchar](50) NULL,
	[StoreCode] [nvarchar](3) NULL,
	[UnitIncPrice] [float] NULL,
	[intlocationid] [int] NULL,
 CONSTRAINT [PK_tblReturnDetails] PRIMARY KEY CLUSTERED
(
	[ReturnDetailsId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblReturns]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblReturns](
	[ReturnId] [int] IDENTITY(9366,1) NOT NULL,
	[ReturnDate] [datetime] NULL,
	[ReturnType] [int] NULL,
	[CustomerId] [int] NULL,
	[OrderId] [int] NULL,
	[Exported] [bit] NULL,
	[DeliveryDate] [datetime] NULL,
	[StockTakeLinkId] [int] NULL,
	[RefNo] [nvarchar](255) NULL,
	[Invoice] [int] NULL,
	[CratesReturned] [int] NULL,
	[CreditNote] [nvarchar](50) NULL,
	[DoNotReturn] [bit] NULL,
	[Disc] [float] NULL,
	[InvoiceRef] [nvarchar](50) NULL,
	[DeliveryAddress] [int] NULL,
	[User] [int] NULL,
	[TimeExported] [datetime] NULL,
	[Printed] [bit] NULL,
	[truckcontrolid] [int] NULL,
	[TimeStamp] [datetime] NULL,
	[Authorised] [bit] NULL,
 CONSTRAINT [PK_tblReturns] PRIMARY KEY CLUSTERED
(
	[ReturnId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblRoutes]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblRoutes](
	[Routeid] [int] IDENTITY(1,1) NOT FOR REPLICATION NOT NULL,
	[Route] [nvarchar](50) NULL,
	[NotInUse] [bit] NOT NULL,
	[InActive] [bit] NOT NULL,
	[NewRec] [bit] NOT NULL,
	[LocationId] [int] NULL,
	[Rmessage] [nvarchar](50) NULL,
	[MinOrderLevel] [float] NULL,
	[locationName] [nvarchar](50) NULL,
	[ID] [int] NULL,
 CONSTRAINT [PK_tblRoutes] PRIMARY KEY CLUSTERED
(
	[Routeid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblSalesCodes]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblSalesCodes](
	[SalesmanCode] [nvarchar](50) NOT NULL,
	[SalesmanDescription] [nvarchar](50) NULL,
	[Blocked] [bit] NOT NULL,
	[SalesTypeId] [int] NULL,
	[Type] [int] NULL,
	[NewRec] [bit] NOT NULL,
	[Email] [nvarchar](255) NULL,
 CONSTRAINT [PK_tblSalesCodes] PRIMARY KEY CLUSTERED
(
	[SalesmanCode] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblSalesmanVisits]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblSalesmanVisits](
	[intVisitId] [bigint] IDENTITY(1,1) NOT NULL,
	[strMessage] [nvarchar](max) NULL,
	[strCatchupMesssage] [nvarchar](max) NULL,
	[dteNextVist] [date] NULL,
	[dtmVisit] [datetime] NULL,
	[intUserId] [int] NULL,
	[strCustomerCode] [nvarchar](50) NULL,
	[Lat] [float] NULL,
	[Lon] [float] NULL,
	[answerIdone] [int] NULL,
	[answertextone] [nvarchar](8) NULL,
	[answeridtwo] [int] NULL,
	[answertexttwo] [nvarchar](8) NULL,
	[answeridthree] [int] NULL,
	[answertextthree] [nvarchar](8) NULL,
	[satisfactionanswers] [nvarchar](500) NULL,
	[ID] [nvarchar](250) NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
/****** Object:  Table [dbo].[tblSalesTargerSummaryPerRep]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblSalesTargerSummaryPerRep](
	[intautosalesid] [bigint] NULL,
	[mnyMade] [money] NULL,
	[mnyTarget] [money] NULL,
	[mnyTogo] [money] NULL,
	[mnyGP] [money] NULL,
	[intweeksleft] [int] NULL,
	[intDaysLeft] [int] NULL,
	[mnyToAchieveintheremainingweeks] [money] NULL,
	[mnyToAchieveintheremainingdays] [money] NULL,
	[strRepName] [nvarchar](50) NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblStartEndTrips]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblStartEndTrips](
	[intInTransitTripID] [bigint] IDENTITY(1,1) NOT NULL,
	[intRouteId] [bigint] NULL,
	[strRouteName] [nvarchar](50) NULL,
	[intOrderType] [bigint] NULL,
	[strOrderType] [nvarchar](50) NULL,
	[intUserID] [bigint] NULL,
	[dteDeliveryDate] [date] NULL,
	[tripStatus] [int] NULL,
	[dteStarted] [datetime] NULL,
	[dteEnded] [datetime] NULL,
	[strCoordinates] [nvarchar](250) NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblStringLog]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblStringLog](
	[Id] [int] IDENTITY(1,1) NOT NULL,
	[Timestamp] [datetime] NULL,
	[StringOut] [nvarchar](max) NULL,
	[StringIn] [nvarchar](max) NULL,
	[SFCRMDocNumber] [nchar](50) NULL,
 CONSTRAINT [PK_StringLog] PRIMARY KEY CLUSTERED
(
	[Id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
/****** Object:  Table [dbo].[tblSurveyAnswers]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblSurveyAnswers](
	[intAutoId] [bigint] IDENTITY(1,1) NOT NULL,
	[intSurveyId] [int] NULL,
	[strSurveyAnswer] [nvarchar](8) NULL,
	[dteTime] [datetime] NULL,
	[strCustomerCode] [nvarchar](50) NULL,
	[intUserId] [int] NULL,
	[intVisitId] [bigint] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblTabletKeys]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblTabletKeys](
	[keyid] [bigint] IDENTITY(1,1) NOT NULL,
	[keystring] [nvarchar](500) NULL,
	[blnActive] [bit] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblTaxes]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblTaxes](
	[TaxId] [int] NOT NULL,
	[TaxCode] [nvarchar](50) NULL,
	[Tax] [float] NULL,
 CONSTRAINT [PK_tblTaxes] PRIMARY KEY CLUSTERED
(
	[TaxId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblTempCall]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblTempCall](
	[CustomerId] [int] NULL,
	[Dates] [datetime] NULL,
	[Show] [bit] NOT NULL,
	[DeliveryAddressId] [int] NULL,
	[Notes] [nvarchar](max) NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
/****** Object:  Table [dbo].[tblTempCategories]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblTempCategories](
	[Category] [nvarchar](50) NOT NULL,
	[Code] [nvarchar](50) NOT NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblTempCustomerBalanceDue]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblTempCustomerBalanceDue](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[CustomerPastelCode] [nvarchar](50) NOT NULL,
	[BalanceDue] [money] NOT NULL,
 CONSTRAINT [PK_tblTempTableCustomerBalances] PRIMARY KEY CLUSTERED
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblTempCustomerDefaultOrders]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblTempCustomerDefaultOrders](
	[CustomerId] [int] NULL,
	[DeliveryAddressId] [int] NULL,
	[ProductId] [int] NULL,
	[Qty] [float] NULL,
	[FactorType] [int] NULL,
	[Factor] [int] NULL,
	[Days] [int] NULL,
	[InvoiceValue] [float] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblTempCustomerDefaultOrders2Weeks]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblTempCustomerDefaultOrders2Weeks](
	[CustomerId] [int] NULL,
	[DeliveryAddressId] [int] NULL,
	[ProductId] [int] NULL,
	[2WeekAvg] [float] NULL,
	[2WeekAvgValue] [float] NULL,
 CONSTRAINT [UniqueKey] UNIQUE NONCLUSTERED
(
	[CustomerId] ASC,
	[DeliveryAddressId] ASC,
	[ProductId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblTempCustSpecials]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblTempCustSpecials](
	[Customer] [nvarchar](50) NOT NULL,
	[ItemCode] [nvarchar](50) NOT NULL,
	[Price] [money] NOT NULL,
	[ExpDate] [date] NOT NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblTempCustSpecialsWebstore]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblTempCustSpecialsWebstore](
	[PastelCode] [nvarchar](50) NOT NULL,
	[PriceIncl] [money] NOT NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblTempOrderDetails]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblTempOrderDetails](
	[ProductId] [int] NOT NULL,
	[orderid] [int] NULL,
	[Qty] [float] NULL,
	[Price] [float] NULL,
	[Loaded] [smallint] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblTempOrderedold]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblTempOrderedold](
	[ProductId] [int] NULL,
	[DeliveryDate] [datetime] NULL,
	[Ordered] [float] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblTempOrders]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblTempOrders](
	[RouteId] [int] NULL,
	[ProductId] [int] NULL,
	[OrderType] [int] NULL,
	[Qty] [float] NULL,
	[TimeStamp] [datetime] NULL,
	[DeliveryDate] [datetime] NULL,
	[Printed] [bit] NOT NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblTempPriceListNames]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblTempPriceListNames](
	[PriceId] [int] NOT NULL,
	[PiceListName] [nvarchar](50) NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblTempProductHistoryFactors]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblTempProductHistoryFactors](
	[ProductId] [int] NOT NULL,
	[FType] [int] NULL,
	[FFactor] [int] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblTempProductOrders]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblTempProductOrders](
	[Code] [nvarchar](50) NOT NULL,
	[DeliveryDate] [datetime] NULL,
	[Cost] [money] NULL,
	[QtyInStock] [money] NULL,
	[QtyAdjThis] [money] NULL,
	[Unit] [nvarchar](4) NULL,
	[Physical] [bit] NOT NULL,
	[LastCost] [money] NULL,
	[AvgCost] [money] NULL,
	[ownerid] [int] NULL,
	[PurchOrder] [money] NULL,
 CONSTRAINT [PK_tblTempProductOrders] PRIMARY KEY CLUSTERED
(
	[Code] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblTempProductOrdersdeletethis]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblTempProductOrdersdeletethis](
	[Code] [nvarchar](50) NULL,
	[DeliveryDate] [datetime] NULL,
	[Cost] [float] NULL,
	[QtyInStock] [float] NULL,
	[QtyAdjThis] [float] NULL,
	[Unit] [nvarchar](4) NULL,
	[Physical] [bit] NOT NULL,
	[LastCost] [float] NULL,
	[AvgCost] [float] NULL,
	[ownerid] [float] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblTempWebstoreCategory]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblTempWebstoreCategory](
	[Category] [nvarchar](50) NULL,
	[Code] [nvarchar](50) NULL,
	[WebstoreDescription] [nvarchar](60) NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblTempWebstoreTemplate]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblTempWebstoreTemplate](
	[strCategory] [nvarchar](50) NULL,
	[strCode] [nvarchar](50) NOT NULL,
	[strPastelDescription] [nvarchar](200) NULL,
	[strWebstoreDescription] [nvarchar](200) NULL,
	[decLength] [money] NULL,
	[decUnitWeight] [money] NULL,
	[strBulkUnit] [nvarchar](50) NULL,
	[strUOM] [nvarchar](50) NULL,
	[decWebstorePrice] [money] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblTepProductsWeights]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblTepProductsWeights](
	[intAutoWeight] [bigint] IDENTITY(1,1) NOT NULL,
	[strCode] [nvarchar](50) NULL,
	[mnyWeight] [money] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblTimedReports]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblTimedReports](
	[intID] [int] IDENTITY(1,1) NOT NULL,
	[strName] [nvarchar](50) NULL,
	[dteRunTime] [time](7) NOT NULL,
	[intNumDays] [int] NOT NULL,
	[dteLastRun] [datetime] NOT NULL,
	[dteNextRun] [datetime] NOT NULL,
	[intType] [int] NOT NULL,
	[strReportPath] [nvarchar](150) NOT NULL,
	[strEmail] [nvarchar](500) NOT NULL,
	[strDatabase] [nvarchar](50) NOT NULL,
 CONSTRAINT [PK_tblTimedReports] PRIMARY KEY CLUSTERED
(
	[intID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblTripEnd]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblTripEnd](
	[intEndTripId] [bigint] IDENTITY(1,1) NOT NULL,
	[strRoute] [nvarchar](50) NULL,
	[strOrderType] [nvarchar](50) NULL,
	[dteDeliveryDate] [nvarchar](50) NULL,
	[strUserName] [nvarchar](50) NULL,
	[strCoordinates] [nvarchar](50) NULL,
	[dtmEndedTrip] [datetime] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblTrucks]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblTrucks](
	[TruckId] [int] IDENTITY(1,1) NOT FOR REPLICATION NOT NULL,
	[TruckName] [nvarchar](50) NULL,
	[RegNo] [nvarchar](50) NULL,
	[Capacity] [float] NULL,
	[Discontiued] [bit] NULL,
	[Tracker] [bit] NULL,
	[StartReading] [float] NULL,
	[Size] [float] NULL,
	[NewRec] [bit] NULL,
	[FuelType] [int] NULL,
	[TankId] [int] NULL,
	[Volume] [int] NULL,
 CONSTRAINT [PK_tblTrucks] PRIMARY KEY CLUSTERED
(
	[TruckId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblVanDriversCash]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblVanDriversCash](
	[intCashOffId] [bigint] IDENTITY(1,1) NOT NULL,
	[mnyCash] [money] NULL,
	[mnyEft] [money] NULL,
	[mnyCard] [money] NULL,
	[dteCashOffDate] [date] NULL,
	[dtmCreated] [datetime] NULL,
	[ID] [nvarchar](50) NULL,
	[strUserName] [nvarchar](50) NULL,
	[intUserId] [int] NULL,
	[isProcessed] [bit] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tblXmldata]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblXmldata](
	[xmId] [bigint] IDENTITY(1,1) NOT NULL,
	[strXML] [xml] NULL,
	[dteCreated] [datetime] NULL,
	[intOptionId] [int] NULL,
	[strType] [nvarchar](50) NULL,
 CONSTRAINT [PK_tblXmldata] PRIMARY KEY CLUSTERED
(
	[xmId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
/****** Object:  Table [dbo].[tblXmlVanSale]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tblXmlVanSale](
	[intXmlId] [bigint] NULL,
	[strXML] [xml] NULL,
	[dteCreated] [datetime] NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
/****** Object:  Table [dbo].[tempAgeAnswers]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tempAgeAnswers](
	[StoreName] [nvarchar](80) NULL,
	[intPTCode] [int] NOT NULL,
	[intPTDays] [int] NOT NULL,
	[strPTInvPer] [nvarchar](50) NOT NULL,
	[intMonthOrDay] [int] NOT NULL,
	[strCustCode] [nvarchar](50) NOT NULL,
	[strNewRef] [nvarchar](50) NULL,
	[dteDocDate] [datetime] NULL,
	[amount] [money] NULL,
	[strAgeNameBuck1] [varchar](9) NOT NULL,
	[strAgeNameBuck2] [varchar](9) NOT NULL,
	[strAgeNameBuck3] [varchar](9) NOT NULL,
	[strAgeNameBuck4] [varchar](9) NOT NULL,
	[strAgeNameBuck5] [varchar](11) NOT NULL,
	[decBucket1] [money] NULL,
	[decBucket2] [money] NULL,
	[decBucket3] [money] NULL,
	[decBucket4] [money] NULL,
	[decBucket5] [money] NULL,
	[decTotal] [money] NULL,
	[intBeyondPaymentTerms] [int] NOT NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[TempCustomers]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[TempCustomers](
	[CustomerPastelCode] [nvarchar](20) NOT NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tempDeliveryAddress]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tempDeliveryAddress](
	[CustomerCode] [nvarchar](6) NOT NULL,
	[CustDelivCode] [nvarchar](10) NULL,
	[SalesmanCode] [nvarchar](5) NULL,
	[Contact] [nvarchar](16) NULL,
	[Telephone] [nvarchar](16) NULL,
	[Cell] [nvarchar](16) NULL,
	[Fax] [nvarchar](16) NULL,
	[DelAddress01] [nvarchar](30) NULL,
	[DelAddress02] [nvarchar](30) NULL,
	[DelAddress03] [nvarchar](30) NULL,
	[DelAddress04] [nvarchar](30) NULL,
	[DelAddress05] [nvarchar](30) NULL,
	[Email] [nvarchar](200) NULL,
	[ContactDocs] [nvarchar](16) NULL,
	[EmailDocs] [nvarchar](200) NULL,
	[ContactStatement] [nvarchar](16) NULL,
	[EmailStatement] [nvarchar](200) NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tempGroups]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tempGroups](
	[strCustomerCode] [nvarchar](50) NULL,
	[intGroup] [int] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[TempTableCustomers]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[TempTableCustomers](
	[CustomerCode] [nvarchar](20) NOT NULL,
	[CustomerStoreName] [nvarchar](250) NOT NULL,
	[CustomerAddress1] [nvarchar](250) NULL,
	[CustomerAddress2] [nvarchar](250) NULL,
	[CustomerAddress3] [nvarchar](250) NULL,
	[CustomerAddress4] [nvarchar](250) NULL,
	[CustomerAddress5] [nvarchar](250) NULL,
	[CustomerLat] [decimal](18, 18) NULL,
	[CustomerLong] [decimal](18, 18) NULL,
	[CustomerContactPerson] [nvarchar](50) NULL,
	[CustomerContactTelephone] [nvarchar](20) NULL,
	[CustomerContactCellphone] [nvarchar](20) NULL,
	[CustomerContactEmail] [nvarchar](50) NULL,
	[CustomerRepresentitiveID] [nvarchar](50) NULL,
	[Monday] [bit] NOT NULL,
	[Tuesday] [bit] NOT NULL,
	[Wednesday] [bit] NOT NULL,
	[Thursday] [bit] NOT NULL,
	[Friday] [bit] NOT NULL,
	[Saturday] [bit] NOT NULL,
	[Sunday] [bit] NOT NULL,
	[CustomerGroup] [nvarchar](50) NULL,
	[CustomerPriceList] [nvarchar](50) NULL,
	[CustomerDefaultRoute] [nvarchar](25) NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[TempTableDeliveryAddresses]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[TempTableDeliveryAddresses](
	[CustomerPastelCode] [nvarchar](50) NULL,
	[DeliveryAddressId] [int] NOT NULL,
	[DAddress1] [nvarchar](50) NULL,
	[DAddress2] [nvarchar](50) NULL,
	[DAddress3] [nvarchar](50) NULL,
	[DAddress4] [nvarchar](50) NULL,
	[DAddress5] [nvarchar](50) NULL,
	[RouteID] [int] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[TempTableGroupSpecials]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[TempTableGroupSpecials](
	[strDesc] [nvarchar](max) NULL,
	[SpecialGroupHeaderId] [int] NULL,
	[DateFrom] [nvarchar](25) NULL,
	[DateTo] [nvarchar](25) NULL,
	[Price] [decimal](18, 2) NULL,
	[GroupId] [nvarchar](25) NULL,
	[strPartNumber] [nvarchar](25) NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
/****** Object:  Table [dbo].[TempTablePriceLists]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[TempTablePriceLists](
	[strPartNumber] [nvarchar](25) NULL,
	[strDesc] [nvarchar](max) NULL,
	[CustomerPriceList] [nvarchar](25) NULL,
	[Date] [nvarchar](25) NULL,
	[Price] [decimal](18, 2) NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
/****** Object:  Table [dbo].[TempTableProducts]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[TempTableProducts](
	[strPartNumber] [nvarchar](250) NOT NULL,
	[strDesc] [nvarchar](250) NOT NULL,
	[strCategory] [nvarchar](250) NULL,
	[Vat] [decimal](18, 0) NULL,
	[ProductID] [bigint] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[TempTableSpecials]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[TempTableSpecials](
	[strDesc] [nvarchar](max) NULL,
	[SpecialHeaderId] [int] NULL,
	[DateFrom] [nvarchar](25) NULL,
	[DateTo] [nvarchar](25) NULL,
	[Price] [decimal](18, 2) NULL,
	[CustomerId] [nvarchar](25) NULL,
	[strPartNumber] [nvarchar](25) NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
/****** Object:  Table [dbo].[TempTableStockOnHand]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[TempTableStockOnHand](
	[strPartNumber] [nvarchar](50) NULL,
	[QtyOnHand] [decimal](18, 2) NOT NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[TMultiStore20200812]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[TMultiStore20200812](
	[ItemCode] [nvarchar](15) NOT NULL,
	[LastPurchAmt] [float] NULL,
	[CostThis13] [float] NULL,
	[QtyOnHand] [float] NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[tProd]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[tProd](
	[ItemCode] [nvarchar](15) NOT NULL,
	[Description] [nvarchar](40) NULL,
	[Blocked] [bit] NULL,
	[UserDefText01] [nvarchar](24) NULL,
	[UserDefText02] [nvarchar](24) NULL,
	[UserDefText03] [nvarchar](24) NULL,
	[UserDefNum01] [money] NULL,
	[UserDefNum02] [money] NULL,
	[UserDefNum03] [money] NULL,
	[NettMass] [money] NULL,
	[SalesTaxType] [int] NULL,
	[Physical] [bit] NULL,
	[Barcode] [nvarchar](15) NULL,
	[Category] [nvarchar](3) NULL,
	[Fixed] [bit] NULL,
	[InvGroup] [nvarchar](3) NULL,
	[Bin] [nvarchar](15) NULL,
	[LastPurchAmt] [money] NULL,
	[ReorderLevel] [int] NULL,
	[MaximumLevel] [int] NULL,
	[UnitSize] [nvarchar](50) NULL
) ON [PRIMARY]
/****** Object:  Table [dbo].[ttTempCustomer]    Script Date: 06/12/2023 10:36:42 AM ******/

CREATE TABLE [dbo].[ttTempCustomer](
	[CustomerCode] [nvarchar](6) NOT NULL,
	[CustomerDesc] [nvarchar](40) NULL,
	[PostAddress01] [nvarchar](30) NULL,
	[PostAddress02] [nvarchar](30) NULL,
	[PostAddress03] [nvarchar](30) NULL,
	[PostAddress04] [nvarchar](30) NULL,
	[PostAddress05] [nvarchar](30) NULL,
	[TaxCode] [int] NULL,
	[ExemptRef] [nvarchar](16) NULL,
	[SettlementTerms] [int] NULL,
	[PaymentTerms] [int] NULL,
	[Blocked] [nvarchar](5) NULL,
	[IncExc] [nvarchar](5) NULL,
	[CreditLimit] [bigint] NULL,
	[UserDefined01] [nvarchar](16) NULL,
	[UserDefined02] [nvarchar](16) NULL,
	[UserDefined03] [nvarchar](16) NULL,
	[UserDefined04] [nvarchar](16) NULL,
	[UserDefined05] [nvarchar](16) NULL,
	[PriceRegime] [int] NULL,
	[Balance] [money] NULL,
	[Category] [nvarchar](50) NULL,
	[Discount] [money] NULL
) ON [PRIMARY]
ALTER TABLE [dbo].[CreditNoteHeader] ADD  CONSTRAINT [DF_CreditNoteHeader_intFlag]  DEFAULT ((0)) FOR [intFlag]
ALTER TABLE [dbo].[CreditNoteHeader] ADD  CONSTRAINT [DF_CreditNoteHeader_HeaderDiscount3]  DEFAULT ((0)) FOR [HeaderDiscount]
ALTER TABLE [dbo].[DriversCashOffRPJ] ADD  CONSTRAINT [DF_DriversCashOffRPJ_intTaxType]  DEFAULT ((0)) FOR [intTaxType]
ALTER TABLE [dbo].[DriversCashOffRPJ] ADD  CONSTRAINT [DF_DriversCashOffRPJ_decTaxAmount]  DEFAULT ((0)) FOR [decTaxAmount]
ALTER TABLE [dbo].[HistoryHeader] ADD  CONSTRAINT [DF_HistoryHeader_DocumentType]  DEFAULT ((1)) FOR [DocumentType]
ALTER TABLE [dbo].[HistoryHeader] ADD  CONSTRAINT [DF_HistoryHeader_CurrentYear]  DEFAULT ((1)) FOR [CurrentYear]
ALTER TABLE [dbo].[HistoryLines] ADD  CONSTRAINT [DF_HistoryLines_CurrentyEAR]  DEFAULT ((1)) FOR [CurrentYear]
ALTER TABLE [dbo].[InventoryTransfers] ADD  CONSTRAINT [DF_InventoryTransfers_intFlag]  DEFAULT ((0)) FOR [intFlag]
ALTER TABLE [dbo].[OrderHeaders] ADD  CONSTRAINT [DF_OrderHeaders_ExportedToDims_1]  DEFAULT ((0)) FOR [ExportedToDims]
ALTER TABLE [dbo].[OrderHeaders] ADD  CONSTRAINT [DF_OrderHeaders_bitBackOrder_1]  DEFAULT ((0)) FOR [bitBackOrder]
ALTER TABLE [dbo].[OrderHeaders] ADD  CONSTRAINT [DF_OrderHeaders_bitCompleted]  DEFAULT ((0)) FOR [bitCompleted]
ALTER TABLE [dbo].[OrderHeaders] ADD  CONSTRAINT [DF_OrderHeaders_intTransactionType]  DEFAULT ((1)) FOR [intTransactionType]
ALTER TABLE [dbo].[SalesInvoiceHeader] ADD  CONSTRAINT [DF_SalesInvoiceHeader_intFlag3]  DEFAULT ((0)) FOR [intFlag]
ALTER TABLE [dbo].[tblAppsRoles] ADD  CONSTRAINT [DF_tblAppsRoles_dteCreated]  DEFAULT (getdate()) FOR [dteCreated]
ALTER TABLE [dbo].[tblAppsRoles] ADD  CONSTRAINT [DF_tblAppsRoles_isRoleEnabled]  DEFAULT ((1)) FOR [isRoleEnabled]
ALTER TABLE [dbo].[tblBrandOrderInvoice] ADD  CONSTRAINT [DF_tblBrandOrderInvoice_Changed]  DEFAULT ((0)) FOR [Changed]
ALTER TABLE [dbo].[tblBrandOrderInvoice] ADD  CONSTRAINT [DF_tblBrandOrderInvoice_CreditIssued]  DEFAULT ((0)) FOR [CreditIssued]
ALTER TABLE [dbo].[tblBrands] ADD  CONSTRAINT [DF_tblBrands_NewRec]  DEFAULT ((0)) FOR [NewRec]
ALTER TABLE [dbo].[tblBreifcaseSurveyQuestions] ADD  CONSTRAINT [DF_tblBreifcaseSurveyQuestions_dtmCreate]  DEFAULT (getdate()) FOR [dtmCreate]
ALTER TABLE [dbo].[tblBreifcaseSurveyQuestions] ADD  CONSTRAINT [DF_tblBreifcaseSurveyQuestions_intLocation]  DEFAULT ((1)) FOR [intLocation]
ALTER TABLE [dbo].[tblBriefcaseReminders] ADD  CONSTRAINT [DF_tblBriefcaseReminders_dteCreated]  DEFAULT (getdate()) FOR [dteCreated]
ALTER TABLE [dbo].[tblCheckIn] ADD  CONSTRAINT [DF_tblCheckIn_dteTimeCreated]  DEFAULT (getdate()) FOR [dteTimeCreated]
ALTER TABLE [dbo].[tblClockInAndOut] ADD  CONSTRAINT [DF_tblClockInAndOut_dteSaved]  DEFAULT (getdate()) FOR [dteSaved]
ALTER TABLE [dbo].[tblCommunications] ADD  CONSTRAINT [DF_tblCommunications_DealtWith]  DEFAULT ((0)) FOR [DealtWith]
ALTER TABLE [dbo].[tblCommunications] ADD  CONSTRAINT [DF_tblCommunications_Response]  DEFAULT ((0)) FOR [Response]
ALTER TABLE [dbo].[tblCommunications] ADD  CONSTRAINT [DF_tblCommunications_Timestamp]  DEFAULT (getdate()) FOR [Timestamp]
ALTER TABLE [dbo].[tblCommunicationsNetwork] ADD  CONSTRAINT [DF_tblCommunicationsNetwork_bitDealtWith]  DEFAULT ((0)) FOR [bitDealtWith]
ALTER TABLE [dbo].[tblCommunicationsNetwork] ADD  CONSTRAINT [DF_tblCommunicationsNetwork_bitResponse]  DEFAULT ((0)) FOR [bitResponse]
ALTER TABLE [dbo].[tblCustomerDefaultOrders] ADD  CONSTRAINT [DF_tblCustomerDefaultOrders_PushProduct]  DEFAULT ((0)) FOR [PushProduct]
ALTER TABLE [dbo].[tblCustomerDeliveryAddress] ADD  CONSTRAINT [DF_tblCustomerDeliveryAddress_NewRec]  DEFAULT ((1)) FOR [NewRec]
ALTER TABLE [dbo].[tblCustomerDeliveryAddress] ADD  CONSTRAINT [DF_tblCustomerDeliveryAddress_DMonday]  DEFAULT ((0)) FOR [DMonday]
ALTER TABLE [dbo].[tblCustomerDeliveryAddress] ADD  CONSTRAINT [DF_tblCustomerDeliveryAddress_DTuesday]  DEFAULT ((0)) FOR [DTuesday]
ALTER TABLE [dbo].[tblCustomerDeliveryAddress] ADD  CONSTRAINT [DF_tblCustomerDeliveryAddress_DWednesday]  DEFAULT ((0)) FOR [DWednesday]
ALTER TABLE [dbo].[tblCustomerDeliveryAddress] ADD  CONSTRAINT [DF_tblCustomerDeliveryAddress_DThursday]  DEFAULT ((0)) FOR [DThursday]
ALTER TABLE [dbo].[tblCustomerDeliveryAddress] ADD  CONSTRAINT [DF_tblCustomerDeliveryAddress_DFriday]  DEFAULT ((0)) FOR [DFriday]
ALTER TABLE [dbo].[tblCustomerDeliveryAddress] ADD  CONSTRAINT [DF_tblCustomerDeliveryAddress_DSaturday]  DEFAULT ((0)) FOR [DSaturday]
ALTER TABLE [dbo].[tblCustomerDeliveryAddress] ADD  CONSTRAINT [DF_tblCustomerDeliveryAddress_DSunday]  DEFAULT ((0)) FOR [DSunday]
ALTER TABLE [dbo].[tblCustomerGeoCoordinates] ADD  CONSTRAINT [DEFAULT_tblCustomerGeoCoordinates_dtetUpdated]  DEFAULT (getdate()) FOR [dtetUpdated]
ALTER TABLE [dbo].[tblCustomerNotes] ADD  CONSTRAINT [DF_tblCustomerNotes_dttimeRecord]  DEFAULT (getdate()) FOR [dttimeRecord]
ALTER TABLE [dbo].[tblCustomers] ADD  CONSTRAINT [DF_tblCustomers_Terms]  DEFAULT ((0)) FOR [Terms]
ALTER TABLE [dbo].[tblCustomers] ADD  CONSTRAINT [DF_tblCustomers_SuspendStandingOrder]  DEFAULT ((0)) FOR [SuspendStandingOrder]
ALTER TABLE [dbo].[tblCustomers] ADD  CONSTRAINT [DF_tblCustomers_TaxExempt]  DEFAULT ((0)) FOR [TaxExempt]
ALTER TABLE [dbo].[tblCustomers] ADD  CONSTRAINT [DF_tblCustomers_Exclusive]  DEFAULT ((0)) FOR [Exclusive]
ALTER TABLE [dbo].[tblCustomers] ADD  CONSTRAINT [DF_tblCustomers_OpenItem]  DEFAULT ((0)) FOR [OpenItem]
ALTER TABLE [dbo].[tblCustomers] ADD  CONSTRAINT [DF_tblCustomers_MonthOrDay]  DEFAULT ((0)) FOR [MonthOrDay]
ALTER TABLE [dbo].[tblCustomers] ADD  CONSTRAINT [DF_tblCustomers_Send]  DEFAULT ((0)) FOR [Send]
ALTER TABLE [dbo].[tblCustomers] ADD  CONSTRAINT [DF_tblCustomers_Monday]  DEFAULT ((0)) FOR [Monday]
ALTER TABLE [dbo].[tblCustomers] ADD  CONSTRAINT [DF_tblCustomers_Tueday]  DEFAULT ((0)) FOR [Tueday]
ALTER TABLE [dbo].[tblCustomers] ADD  CONSTRAINT [DF_tblCustomers_Wednesday]  DEFAULT ((0)) FOR [Wednesday]
ALTER TABLE [dbo].[tblCustomers] ADD  CONSTRAINT [DF_tblCustomers_Thursday]  DEFAULT ((0)) FOR [Thursday]
ALTER TABLE [dbo].[tblCustomers] ADD  CONSTRAINT [DF_tblCustomers_Friday]  DEFAULT ((0)) FOR [Friday]
ALTER TABLE [dbo].[tblCustomers] ADD  CONSTRAINT [DF_tblCustomers_Saturday]  DEFAULT ((0)) FOR [Saturday]
ALTER TABLE [dbo].[tblCustomers] ADD  CONSTRAINT [DF_tblCustomers_Sunday]  DEFAULT ((0)) FOR [Sunday]
ALTER TABLE [dbo].[tblCustomers] ADD  CONSTRAINT [DF_tblCustomers_QuoteorInvoice]  DEFAULT ((0)) FOR [QuoteorInvoice]
ALTER TABLE [dbo].[tblCustomers] ADD  CONSTRAINT [DF_tblCustomers_NewRec]  DEFAULT ((0)) FOR [NewRec]
ALTER TABLE [dbo].[tblCustomers] ADD  CONSTRAINT [DF_tblCustomers_UniqueDelivery]  DEFAULT ((0)) FOR [UniqueDelivery]
ALTER TABLE [dbo].[tblCustomers] ADD  CONSTRAINT [DF_tblCustomers_MultipleDeliveries]  DEFAULT ((0)) FOR [MultipleDeliveries]
ALTER TABLE [dbo].[tblCustomers] ADD  CONSTRAINT [DF_tblCustomers_DoNotInvoice]  DEFAULT ((0)) FOR [DoNotInvoice]
ALTER TABLE [dbo].[tblCustomers] ADD  CONSTRAINT [DF_tblCustomers_DoNotReturn]  DEFAULT ((0)) FOR [DoNotReturn]
ALTER TABLE [dbo].[tblCustomers] ADD  CONSTRAINT [DF_tblCustomers_CashOnly]  DEFAULT ((0)) FOR [CashOnly]
ALTER TABLE [dbo].[tblCustomers] ADD  CONSTRAINT [DF_tblCustomers_Account]  DEFAULT ((0)) FOR [Account]
ALTER TABLE [dbo].[tblCustomers] ADD  CONSTRAINT [DF_tblCustomers_Driver]  DEFAULT ((0)) FOR [Driver]
ALTER TABLE [dbo].[tblCustomers] ADD  CONSTRAINT [DF_tblCustomers_Fridge]  DEFAULT ((0)) FOR [Fridge]
ALTER TABLE [dbo].[tblCustomers] ADD  CONSTRAINT [DF_tblCustomers_UserID]  DEFAULT ((1)) FOR [UserID]
ALTER TABLE [dbo].[tblCustomers] ADD  CONSTRAINT [DF_tblCustomers_EMailInvoice]  DEFAULT ((0)) FOR [EMailInvoice]
ALTER TABLE [dbo].[tblCustomers] ADD  CONSTRAINT [DF_tblCustomers_Dontsplit]  DEFAULT ((0)) FOR [Dontsplit]
ALTER TABLE [dbo].[tblCustomers] ADD  CONSTRAINT [DF_tblCustomers_PriorityCustomer]  DEFAULT ((0)) FOR [PriorityCustomer]
ALTER TABLE [dbo].[tblCustomers] ADD  CONSTRAINT [DF_tblCustomers_CustomerOnHold]  DEFAULT ((0)) FOR [CustomerOnHold]
ALTER TABLE [dbo].[tblCustomers] ADD  CONSTRAINT [DF_tblCustomers_intLocationId]  DEFAULT ((1)) FOR [intLocationId]
ALTER TABLE [dbo].[tblCustomerSpecials] ADD  CONSTRAINT [DF_tblCustomerSpecials_NewRec]  DEFAULT ((0)) FOR [NewRec]
ALTER TABLE [dbo].[tblDeliveryDateRouting] ADD  CONSTRAINT [DF_tblDeliveryDateRouting_NewRec]  DEFAULT ((0)) FOR [NewRec]
ALTER TABLE [dbo].[tblDeliveryDateRouting] ADD  CONSTRAINT [DF_tblDeliveryDateRouting_LoadingStarted]  DEFAULT ((0)) FOR [LoadingStarted]
ALTER TABLE [dbo].[tblDeliveryDateRouting] ADD  CONSTRAINT [DF_tblDeliveryDateRouting_Closed]  DEFAULT ((0)) FOR [Closed]
ALTER TABLE [dbo].[tblDeliveryDateRouting] ADD  CONSTRAINT [DF_tblDeliveryDateRouting_blnVerified_1]  DEFAULT ((0)) FOR [blnVerified]
ALTER TABLE [dbo].[tblDeliveryDates] ADD  CONSTRAINT [DF_tblDeliveryDates_InvoiceWritten]  DEFAULT ((0)) FOR [InvoiceWritten]
ALTER TABLE [dbo].[tblDeliveryDates] ADD  CONSTRAINT [DF_tblDeliveryDates_NotOpenForLoading]  DEFAULT ((0)) FOR [NotOpenForLoading]
ALTER TABLE [dbo].[tblDimsBriefcaseMemos] ADD  CONSTRAINT [DF_tblDimsBriefcaseMemos_dteTimeCreate]  DEFAULT (getdate()) FOR [dteTimeCreate]
ALTER TABLE [dbo].[tblDIMSGroupSetup] ADD  CONSTRAINT [DF_tblDIMSGroupSetup_Selected]  DEFAULT ((0)) FOR [Selected]
ALTER TABLE [dbo].[tblDIMSUSERS] ADD  CONSTRAINT [DF_tblDIMSUSERS_StatusId]  DEFAULT ((0)) FOR [StatusId]
ALTER TABLE [dbo].[tblDIMSUSERS] ADD  CONSTRAINT [DF_tblDIMSUSERS_LoggedIn]  DEFAULT ((0)) FOR [LoggedIn]
ALTER TABLE [dbo].[tblDIMSUSERS] ADD  CONSTRAINT [DF_tblDIMSUSERS_Exporting]  DEFAULT ((0)) FOR [Exporting]
ALTER TABLE [dbo].[tblDIMSUSERS] ADD  CONSTRAINT [DF_tblDIMSUSERS_exportAllOrders]  DEFAULT ((0)) FOR [exportAllOrders]
ALTER TABLE [dbo].[tblDIMSUSERS] ADD  CONSTRAINT [DF_tblDIMSUSERS_ExportAllReturns]  DEFAULT ((0)) FOR [ExportAllReturns]
ALTER TABLE [dbo].[tblDIMSUSERS] ADD  CONSTRAINT [DF_tblDIMSUSERS_refreshstock]  DEFAULT ((0)) FOR [refreshstock]
ALTER TABLE [dbo].[tblDIMSUSERS] ADD  CONSTRAINT [DF_tblDIMSUSERS_TabletUser]  DEFAULT ((0)) FOR [TabletUser]
ALTER TABLE [dbo].[tblDIMSUSERS] ADD  CONSTRAINT [DF_tblDIMSUSERS_ReceiveSalesBroadCasts]  DEFAULT ((0)) FOR [ReceiveSalesBroadCasts]
ALTER TABLE [dbo].[tblDIMSUSERS] ADD  CONSTRAINT [DF_tblDIMSUSERS_RunPastelLinks]  DEFAULT ((0)) FOR [RunPastelLinks]
ALTER TABLE [dbo].[tblDIMSUSERS] ADD  CONSTRAINT [DF_tblDIMSUSERS_authInvoices]  DEFAULT ((0)) FOR [authInvoices]
ALTER TABLE [dbo].[tblDIMSUSERS] ADD  CONSTRAINT [DF_tblDIMSUSERS_intAllowMultiLines]  DEFAULT ((0)) FOR [intAllowMultiLines]
ALTER TABLE [dbo].[tblDrivers] ADD  CONSTRAINT [DF_tblDrivers_InActive]  DEFAULT ((0)) FOR [InActive]
ALTER TABLE [dbo].[tblDrivers] ADD  CONSTRAINT [DF_tblDrivers_NewRec]  DEFAULT ((0)) FOR [NewRec]
ALTER TABLE [dbo].[tblDriversAppCreditRequestHeader] ADD  CONSTRAINT [DF_tblDriversAppCreditRequestHeader_dtePostDateTime]  DEFAULT (getdate()) FOR [dtePostDateTime]
ALTER TABLE [dbo].[tblDriversAppCreditRequestLines] ADD  CONSTRAINT [DF_tblDriversAppCreditRequestLines_dtePosted]  DEFAULT (getdate()) FOR [dtePosted]
ALTER TABLE [dbo].[tblDriversAppTripHeader] ADD  CONSTRAINT [DF_tblDriversAppTripHeader_dtm]  DEFAULT (getdate()) FOR [dtm]
ALTER TABLE [dbo].[tblDriversCashOff] ADD  CONSTRAINT [DF_tblDriversCashOff_Exported]  DEFAULT ((0)) FOR [Exported]
ALTER TABLE [dbo].[tblDriversCashOff] ADD  CONSTRAINT [DF_tblDriversCashOff_CustOrGL]  DEFAULT ((0)) FOR [CustOrGL]
ALTER TABLE [dbo].[tblDriversCashOff] ADD  CONSTRAINT [DF_tblDriversCashOff_JournalExport]  DEFAULT ((0)) FOR [JournalExport]
ALTER TABLE [dbo].[tblDriversCashOffCash] ADD  CONSTRAINT [DF_tblDriversCashOffCash_Exported]  DEFAULT ((0)) FOR [Exported]
ALTER TABLE [dbo].[tblDriversCashoffExpenses] ADD  CONSTRAINT [DF_tblDriversCashoffExpenses_Exported]  DEFAULT ((0)) FOR [Exported]
ALTER TABLE [dbo].[tblDriversCashoffExpenses] ADD  CONSTRAINT [DF_tblDriversCashoffExpenses_JournalExport]  DEFAULT ((0)) FOR [JournalExport]
ALTER TABLE [dbo].[tblDriversCashOffInvoices] ADD  CONSTRAINT [DF_tblDriversCashOffInvoices_Exported]  DEFAULT ((0)) FOR [Exported]
ALTER TABLE [dbo].[tblDriversCashOffInvoices] ADD  CONSTRAINT [DF_tblDriversCashOffInvoices_NotGotPOD]  DEFAULT ((0)) FOR [NotGotPOD]
ALTER TABLE [dbo].[tblDriversCashOffInvoices] ADD  CONSTRAINT [DF_tblDriversCashOffInvoices_Redeliver]  DEFAULT ((0)) FOR [Redeliver]
ALTER TABLE [dbo].[tblDriversCashOffInvoices] ADD  CONSTRAINT [DF_tblDriversCashOffInvoices_JournalExport]  DEFAULT ((0)) FOR [JournalExport]
ALTER TABLE [dbo].[tblGLCodes] ADD  CONSTRAINT [DF_tblGLCodes_Blocked]  DEFAULT ((0)) FOR [Blocked]
ALTER TABLE [dbo].[tblGroupBrands] ADD  CONSTRAINT [DF_tblGroupBrands_NewRec]  DEFAULT ((0)) FOR [NewRec]
ALTER TABLE [dbo].[tblGroups] ADD  CONSTRAINT [DF_tblGroups_InvoiceSeperately]  DEFAULT ((0)) FOR [InvoiceSeperately]
ALTER TABLE [dbo].[tblGroups] ADD  CONSTRAINT [DF_tblGroups_NewRec]  DEFAULT ((0)) FOR [NewRec]
ALTER TABLE [dbo].[tblGroupSpecials] ADD  CONSTRAINT [DF_tblGroupSpecials_NewRec]  DEFAULT ((0)) FOR [NewRec]
ALTER TABLE [dbo].[tblInvoicePath] ADD  CONSTRAINT [DF_tblInvoicePath_dteTimeStamp]  DEFAULT (getdate()) FOR [dteTimeStamp]
ALTER TABLE [dbo].[tblLinxHtmlReport] ADD  CONSTRAINT [DF_tblLinxHtmlReport_dtm]  DEFAULT (getdate()) FOR [dtm]
ALTER TABLE [dbo].[tblManagementConsol] ADD  CONSTRAINT [DF_tblManagementConsol_dtm]  DEFAULT (getdate()) FOR [dtm]
ALTER TABLE [dbo].[tblManagementConsol] ADD  CONSTRAINT [DF_tblManagementConsol_Reviewed]  DEFAULT ((0)) FOR [Reviewed]
ALTER TABLE [dbo].[tblNoStockItems] ADD  CONSTRAINT [DF_tblNoStockItems_dtDateLasteSent]  DEFAULT (getdate()) FOR [dtDateLasteSent]
ALTER TABLE [dbo].[tblNotiFicationsCreated] ADD  CONSTRAINT [DF_tblNotiFicationsCreated_dtCreation]  DEFAULT (getdate()) FOR [dtCreation]
ALTER TABLE [dbo].[tblNotiFicationsCreated] ADD  CONSTRAINT [DF_tblNotiFicationsCreated_blnAttended]  DEFAULT ((0)) FOR [blnAttended]
ALTER TABLE [dbo].[tblOrderDetails] ADD  CONSTRAINT [DF_tblOrderDetails_StandingOrder]  DEFAULT ((0)) FOR [StandingOrder]
ALTER TABLE [dbo].[tblOrderDetails] ADD  CONSTRAINT [DF_tblOrderDetails_Printed]  DEFAULT ((0)) FOR [Printed]
ALTER TABLE [dbo].[tblOrderDetails] ADD  CONSTRAINT [DF_tblOrderDetails_timestamp]  DEFAULT (getdate()) FOR [timestamp]
ALTER TABLE [dbo].[tblOrderDetails] ADD  CONSTRAINT [DF_tblOrderDetails_LineDisc]  DEFAULT ((0)) FOR [LineDisc]
ALTER TABLE [dbo].[tblOrderDetails] ADD  CONSTRAINT [DF_tblOrderDetails_CheckedOut]  DEFAULT ((0)) FOR [CheckedOut]
ALTER TABLE [dbo].[tblOrderDetails] ADD  CONSTRAINT [DF_tblOrderDetails_DetailsDiscount]  DEFAULT ((0)) FOR [DetailsDiscount]
ALTER TABLE [dbo].[tblOrderDetails] ADD  CONSTRAINT [DF_tblOrderDetails_LineDisc2]  DEFAULT ((0)) FOR [LineDisc2]
ALTER TABLE [dbo].[tblOrderDetails] ADD  CONSTRAINT [DF_tblOrderDetails_LineDisc3]  DEFAULT ((0)) FOR [LineDisc3]
ALTER TABLE [dbo].[tblOrderDetails] ADD  CONSTRAINT [DF_tblOrderDetails_LineDisc4]  DEFAULT ((0)) FOR [LineDisc4]
ALTER TABLE [dbo].[tblOrderDetails] ADD  CONSTRAINT [DF_tblOrderDetails_VolumeDisc]  DEFAULT ((0)) FOR [VolumeDisc]
ALTER TABLE [dbo].[tblOrderDetails] ADD  CONSTRAINT [DF_tblOrderDetails_Authorised]  DEFAULT ((0)) FOR [Authorised]
ALTER TABLE [dbo].[tblOrderDetails] ADD  CONSTRAINT [DF_tblOrderDetails_Loaded]  DEFAULT ((0)) FOR [Loaded]
ALTER TABLE [dbo].[tblOrderDetails] ADD  CONSTRAINT [DF_tblOrderDetails_blnPicked]  DEFAULT ((0)) FOR [blnPicked]
ALTER TABLE [dbo].[tblOrderDetails] ADD  CONSTRAINT [DF_tblOrderDetails_intLocationId]  DEFAULT ((1)) FOR [intLocationId]
ALTER TABLE [dbo].[tblOrderDetails] ADD  CONSTRAINT [DF_tblOrderDetails_inthiddentoken]  DEFAULT ((111)) FOR [intHiddenToken]
ALTER TABLE [dbo].[tblOrderDetails] ADD  CONSTRAINT [DF_tblOrderDetails_mnyQtyRemaining]  DEFAULT ((0)) FOR [mnyQtyRemaining]
ALTER TABLE [dbo].[tblOrderDetails] ADD  CONSTRAINT [DF_tblOrderDetails_blnCostAuth]  DEFAULT ((1)) FOR [blnCostAuth]
ALTER TABLE [dbo].[tblOrderDetails] ADD  CONSTRAINT [DF_tblOrderDetails_dteLineRequisition]  DEFAULT (getdate()) FOR [dteLineRequisition]
ALTER TABLE [dbo].[tblOrderDetailsForOtherTransactions] ADD  CONSTRAINT [DF_tblOrderDetailsForOtherTransactions_StandingOrder]  DEFAULT ((0)) FOR [StandingOrder]
ALTER TABLE [dbo].[tblOrderDetailsForOtherTransactions] ADD  CONSTRAINT [DF_tblOrderDetailsForOtherTransactions_Printed]  DEFAULT ((0)) FOR [Printed]
ALTER TABLE [dbo].[tblOrderDetailsForOtherTransactions] ADD  CONSTRAINT [DF_tblOrderDetailsForOtherTransactions_CheckedOut]  DEFAULT ((0)) FOR [CheckedOut]
ALTER TABLE [dbo].[tblOrderDetailsForOtherTransactions] ADD  CONSTRAINT [DF_tblOrderDetailsForOtherTransactions_Authorised]  DEFAULT ((0)) FOR [Authorised]
ALTER TABLE [dbo].[tblOrderDetailsForOtherTransactions] ADD  CONSTRAINT [DF_tblOrderDetailsForOtherTransactions_QtyTrimFlag]  DEFAULT ((0)) FOR [QtyTrimFlag]
ALTER TABLE [dbo].[tblOrderDetailsForOtherTransactions] ADD  CONSTRAINT [DF_tblOrderDetailsForOtherTransactions_Loaded]  DEFAULT ((0)) FOR [Loaded]
ALTER TABLE [dbo].[tblOrderDetailsForOtherTransactions] ADD  CONSTRAINT [DF_tblOrderDetailsForOtherTransactions_blnPicked]  DEFAULT ((0)) FOR [blnPicked]
ALTER TABLE [dbo].[tblOrderLocks] ADD  CONSTRAINT [DF_tblOrderLocks_TimeStamp]  DEFAULT (getdate()) FOR [TimeStamp]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_Invoiced]  DEFAULT ((0)) FOR [Invoiced]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_Rebate]  DEFAULT ((0)) FOR [Rebate]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_CratesSet]  DEFAULT ((0)) FOR [CratesSet]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_TimeSet]  DEFAULT ((0)) FOR [TimeSet]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_timestamp]  DEFAULT (getdate()) FOR [timestamp]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_LongTermCheck]  DEFAULT ((0)) FOR [LongTermCheck]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_CreditIssued]  DEFAULT ((0)) FOR [CreditIssued]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_DoNotInvoice]  DEFAULT ((0)) FOR [DoNotInvoice]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_Disc]  DEFAULT ((0)) FOR [Disc]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_NewRec]  DEFAULT ((0)) FOR [NewRec]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_Printed]  DEFAULT ((0)) FOR [Printed]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_PickPrinted]  DEFAULT ((0)) FOR [PickPrinted]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_ReInvoice]  DEFAULT ((0)) FOR [ReInvoice]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_Backorder]  DEFAULT ((0)) FOR [Backorder]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_hide]  DEFAULT ((0)) FOR [hide]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_StandingOrder]  DEFAULT ((0)) FOR [StandingOrder]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_Authorised]  DEFAULT ((0)) FOR [Authorised]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_NoAssigned]  DEFAULT ((0)) FOR [NoAssigned]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_Selected]  DEFAULT ((0)) FOR [Selected]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_OrderHasDetail]  DEFAULT ((0)) FOR [OrderHasDetail]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_Loaded]  DEFAULT ((0)) FOR [Loaded]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_OrderLock]  DEFAULT ((0)) FOR [OrderLock]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_AwaitingStock]  DEFAULT ((0)) FOR [AwaitingStock]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_blnProcessed]  DEFAULT ((0)) FOR [blnProcessed]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_blnPicked]  DEFAULT ((0)) FOR [blnPicked]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_blnPriority]  DEFAULT ((0)) FOR [blnPriority]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_tmOrderCollectedFromPrinter]  DEFAULT (getdate()) FOR [tmOrderCollectedFromPrinter]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_blnBackOrderSent]  DEFAULT ((0)) FOR [blnBackOrderSent]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_TreatAsQuotation]  DEFAULT ((0)) FOR [TreatAsQuotation]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_blnCreditLimitNotificationSent]  DEFAULT ((0)) FOR [blnCreditLimitNotificationSent]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_offloaded]  DEFAULT ((0)) FOR [offloaded]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_bitEmailSentToCustomerAfterLoading]  DEFAULT ((0)) FOR [bitEmailSentToCustomerAfterLoading]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_dtimeTripStart]  DEFAULT (getdate()) FOR [dtimeTripStart]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_dtimeTripEnd]  DEFAULT (getdate()) FOR [dtimeTripEnd]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_dteOffloadedTime]  DEFAULT (getdate()) FOR [dteOffloadedTime]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_intSpecialOrder]  DEFAULT ((0)) FOR [intSpecialOrder]
ALTER TABLE [dbo].[tblOrders] ADD  CONSTRAINT [DF_tblOrders_blnDeliveryNotePrinted]  DEFAULT ((0)) FOR [blnDeliveryNotePrinted]
ALTER TABLE [dbo].[tblOrderSalesCodes] ADD  CONSTRAINT [DF_tblOrderSalesCodes_OrderCancelled]  DEFAULT ((0)) FOR [OrderCancelled]
ALTER TABLE [dbo].[tblOrdersPickedSinceLastCheck] ADD  CONSTRAINT [DF_tblOrdersPickedSinceLastCheck_dteTimeStamp]  DEFAULT (getdate()) FOR [dteTimeStamp]
ALTER TABLE [dbo].[tblOverallSpecials] ADD  CONSTRAINT [DF_tblOverallSpecials_intLocationId]  DEFAULT ((1)) FOR [intLocationId]
ALTER TABLE [dbo].[tblOwners] ADD  CONSTRAINT [DF_tblOwners_bitCustomerOwner]  DEFAULT ((0)) FOR [bitCustomerOwner]
ALTER TABLE [dbo].[tblOwners] ADD  CONSTRAINT [DF_tblOwners_bitStockOwner]  DEFAULT ((0)) FOR [bitStockOwner]
ALTER TABLE [dbo].[tblOwners] ADD  CONSTRAINT [DF_tblOwners_bitForceUpdate]  DEFAULT ((0)) FOR [bitForceUpdatePricing]
ALTER TABLE [dbo].[tblPickedQtyTablets] ADD  CONSTRAINT [DF_tblPickedQtyTablets_dteTime]  DEFAULT (getdate()) FOR [dteTime]
ALTER TABLE [dbo].[tblPickingAppCases] ADD  CONSTRAINT [DF_tblPickingAppCases_dteCreated]  DEFAULT (getdate()) FOR [dteCreated]
ALTER TABLE [dbo].[tblPrintedDocuments] ADD  CONSTRAINT [DF_tblPrintedDocuments_TimePrinted]  DEFAULT (getdate()) FOR [TimePrinted]
ALTER TABLE [dbo].[tblPrintedDocuments] ADD  CONSTRAINT [DF_tblPrintedDocuments_Printed]  DEFAULT ((0)) FOR [Printed]
ALTER TABLE [dbo].[tblPrintedDocuments] ADD  CONSTRAINT [DF_tblPrintedDocuments_PrintDeliveryNote]  DEFAULT ((0)) FOR [PrintDeliveryNote]
ALTER TABLE [dbo].[tblPrintedDocuments] ADD  CONSTRAINT [DF_tblPrintedDocuments_Attempted]  DEFAULT ((1)) FOR [Attempted]
ALTER TABLE [dbo].[tblPrintedDocumentsFiles] ADD  CONSTRAINT [DF_tblPrintedDocumentsFiles_dteTimeStamp]  DEFAULT (getdate()) FOR [dteTimeStamp]
ALTER TABLE [dbo].[tblPrintedPicking] ADD  CONSTRAINT [DF_tblPrintedBulkPicking_Timestamp]  DEFAULT (getdate()) FOR [Timestamp]
ALTER TABLE [dbo].[tblPrintedPicking] ADD  CONSTRAINT [DF_tblPrintedBulkPicking_Attempted]  DEFAULT ((0)) FOR [Attempted]
ALTER TABLE [dbo].[tblProducts] ADD  CONSTRAINT [DF_tblProducts_CategoryId]  DEFAULT ((1)) FOR [CategoryId]
ALTER TABLE [dbo].[tblProducts] ADD  CONSTRAINT [DF_tblProducts_DisableShortage]  DEFAULT ((0)) FOR [DisableShortage]
ALTER TABLE [dbo].[tblProducts] ADD  CONSTRAINT [DF_tblProducts_DeListOrder]  DEFAULT ((0)) FOR [DeListOrder]
ALTER TABLE [dbo].[tblProducts] ADD  CONSTRAINT [DF_tblProducts_ListedProduct]  DEFAULT ((0)) FOR [ListedProduct]
ALTER TABLE [dbo].[tblProducts] ADD  CONSTRAINT [DF_tblProducts_DarkLine]  DEFAULT ((0)) FOR [DarkLine]
ALTER TABLE [dbo].[tblProducts] ADD  CONSTRAINT [DF_tblProducts_TurnOnEBD]  DEFAULT ((0)) FOR [TurnOnEBD]
ALTER TABLE [dbo].[tblProducts] ADD  CONSTRAINT [DF_tblProducts_WeeklyProduction]  DEFAULT ((0)) FOR [WeeklyProduction]
ALTER TABLE [dbo].[tblProducts] ADD  CONSTRAINT [DF_tblProducts_PhysicalItem]  DEFAULT ((0)) FOR [PhysicalItem]
ALTER TABLE [dbo].[tblProducts] ADD  CONSTRAINT [DF_tblProducts_FixedDescription]  DEFAULT ((0)) FOR [FixedDescription]
ALTER TABLE [dbo].[tblProducts] ADD  CONSTRAINT [DF_tblProducts_NewRec]  DEFAULT ((0)) FOR [NewRec]
ALTER TABLE [dbo].[tblProducts] ADD  CONSTRAINT [DF_tblProducts_AYR]  DEFAULT ((0)) FOR [AYR]
ALTER TABLE [dbo].[tblProducts] ADD  CONSTRAINT [DF_tblProducts_StockManagement]  DEFAULT ((0)) FOR [StockManagement]
ALTER TABLE [dbo].[tblProducts] ADD  CONSTRAINT [DF_tblProducts_Consignment]  DEFAULT ((0)) FOR [Consignment]
ALTER TABLE [dbo].[tblProducts] ADD  CONSTRAINT [DF_tblProducts_LastCostConsignment]  DEFAULT ((0)) FOR [LastCostConsignment]
ALTER TABLE [dbo].[tblProducts] ADD  CONSTRAINT [DF_tblProducts_MultiLineItem]  DEFAULT ((0)) FOR [MultiLineItem]
ALTER TABLE [dbo].[tblProducts] ADD  CONSTRAINT [DF_tblProducts_SoldByWeight]  DEFAULT ((0)) FOR [SoldByWeight]
ALTER TABLE [dbo].[tblProducts] ADD  CONSTRAINT [DF_tblProducts_PriceManagement]  DEFAULT ((0)) FOR [PriceManagement]
ALTER TABLE [dbo].[tblProducts] ADD  CONSTRAINT [DF_tblProducts_ManageCosts]  DEFAULT ((0)) FOR [ManageCosts]
ALTER TABLE [dbo].[tblProducts] ADD  CONSTRAINT [DF_tblProducts_PriorityProduct]  DEFAULT ((0)) FOR [PriorityProduct]
ALTER TABLE [dbo].[tblProducts] ADD  CONSTRAINT [DF_tblProducts_AllowZeroPrice]  DEFAULT ((0)) FOR [AllowZeroPrice]
ALTER TABLE [dbo].[tblProducts] ADD  CONSTRAINT [DF_tblProducts_bitIsWebstoreItem]  DEFAULT ((0)) FOR [bitIsWebstoreItem]
ALTER TABLE [dbo].[tblProducts] ADD  CONSTRAINT [DF_tblProducts_bitAllowDiscount]  DEFAULT ((1)) FOR [bitAllowDiscount]
ALTER TABLE [dbo].[tblReturnDetails] ADD  CONSTRAINT [DF_tblReturnDetails_LineExported]  DEFAULT ((0)) FOR [LineExported]
ALTER TABLE [dbo].[tblReturns] ADD  CONSTRAINT [DF_tblReturns_Exported]  DEFAULT ((0)) FOR [Exported]
ALTER TABLE [dbo].[tblReturns] ADD  CONSTRAINT [DF_tblReturns_DoNotReturn]  DEFAULT ((0)) FOR [DoNotReturn]
ALTER TABLE [dbo].[tblReturns] ADD  CONSTRAINT [DF_tblReturns_Printed]  DEFAULT ((0)) FOR [Printed]
ALTER TABLE [dbo].[tblReturns] ADD  CONSTRAINT [DF_tblReturns_TimeStamp]  DEFAULT (getdate()) FOR [TimeStamp]
ALTER TABLE [dbo].[tblReturns] ADD  CONSTRAINT [DF_tblReturns_Authorised]  DEFAULT ((0)) FOR [Authorised]
ALTER TABLE [dbo].[tblRoutes] ADD  CONSTRAINT [DF_tblRoutes_NotInUse]  DEFAULT ((0)) FOR [NotInUse]
ALTER TABLE [dbo].[tblRoutes] ADD  CONSTRAINT [DF_tblRoutes_InActive]  DEFAULT ((0)) FOR [InActive]
ALTER TABLE [dbo].[tblRoutes] ADD  CONSTRAINT [DF_tblRoutes_NewRec]  DEFAULT ((0)) FOR [NewRec]
ALTER TABLE [dbo].[tblRoutes] ADD  CONSTRAINT [DF_tblRoutes_LocationId]  DEFAULT ((1)) FOR [LocationId]
ALTER TABLE [dbo].[tblSalesCodes] ADD  CONSTRAINT [DF_tblSalesCodes_Blocked]  DEFAULT ((0)) FOR [Blocked]
ALTER TABLE [dbo].[tblSalesCodes] ADD  CONSTRAINT [DF_tblSalesCodes_NewRec]  DEFAULT ((0)) FOR [NewRec]
ALTER TABLE [dbo].[tblSalesmanVisits] ADD  CONSTRAINT [DF_tblSalesmanVisits_dtmVisit]  DEFAULT (getdate()) FOR [dtmVisit]
ALTER TABLE [dbo].[tblStartEndTrips] ADD  CONSTRAINT [DF_tblStartEndTrips_tripStatus]  DEFAULT ((0)) FOR [tripStatus]
ALTER TABLE [dbo].[tblStartEndTrips] ADD  CONSTRAINT [DF_tblStartEndTrips_dteStarted]  DEFAULT (getdate()) FOR [dteStarted]
ALTER TABLE [dbo].[tblStringLog] ADD  CONSTRAINT [DF_StringLog_Timestamp]  DEFAULT (getdate()) FOR [Timestamp]
ALTER TABLE [dbo].[tblSurveyAnswers] ADD  CONSTRAINT [DF_tblSurveyAnswers_dteTime]  DEFAULT (getdate()) FOR [dteTime]
ALTER TABLE [dbo].[tblTabletKeys] ADD  CONSTRAINT [DF_tblTabletKeys_blnActive]  DEFAULT ((0)) FOR [blnActive]
ALTER TABLE [dbo].[tblTimedReports] ADD  CONSTRAINT [DF_tblTimedReports_intNumDays]  DEFAULT ((1)) FOR [intNumDays]
ALTER TABLE [dbo].[tblTripEnd] ADD  CONSTRAINT [DF_tblTripEnd_dtmEndedTrip]  DEFAULT (getdate()) FOR [dtmEndedTrip]
ALTER TABLE [dbo].[tblTrucks] ADD  CONSTRAINT [DF_tblTrucks_Discontiued]  DEFAULT ((0)) FOR [Discontiued]
ALTER TABLE [dbo].[tblTrucks] ADD  CONSTRAINT [DF_tblTrucks_Tracker]  DEFAULT ((0)) FOR [Tracker]
ALTER TABLE [dbo].[tblTrucks] ADD  CONSTRAINT [DF_tblTrucks_NewRec]  DEFAULT ((0)) FOR [NewRec]
ALTER TABLE [dbo].[tblVanDriversCash] ADD  CONSTRAINT [DF_tblVanDriversCash_dtmCreated]  DEFAULT (getdate()) FOR [dtmCreated]
ALTER TABLE [dbo].[tblXmldata] ADD  CONSTRAINT [DF_tblXmldata_dteCreated]  DEFAULT (getdate()) FOR [dteCreated]
ALTER TABLE [dbo].[tblXmlVanSale] ADD  CONSTRAINT [DF_tblXmlVanSale_dteCreated]  DEFAULT (getdate()) FOR [dteCreated]
ALTER TABLE [dbo].[tblCommunicationsNetwork]  WITH CHECK ADD  CONSTRAINT [FK_tblCommunicationsNetwork_tblCommunicationsNetwork] FOREIGN KEY([intID])
REFERENCES [dbo].[tblCommunicationsNetwork] ([intID])
ALTER TABLE [dbo].[tblCommunicationsNetwork] CHECK CONSTRAINT [FK_tblCommunicationsNetwork_tblCommunicationsNetwork]
ALTER TABLE [dbo].[tblOrderDetails]  WITH CHECK ADD  CONSTRAINT [FK_tblOrderDetails_tblOrders] FOREIGN KEY([OrderId])
REFERENCES [dbo].[tblOrders] ([OrderId])
ALTER TABLE [dbo].[tblOrderDetails] CHECK CONSTRAINT [FK_tblOrderDetails_tblOrders]
ALTER TABLE [dbo].[tblOrders]  WITH CHECK ADD  CONSTRAINT [FK_tblOrders_tblCustomers] FOREIGN KEY([CustomerId])
REFERENCES [dbo].[tblCustomers] ([CustomerId])
ALTER TABLE [dbo].[tblOrders] CHECK CONSTRAINT [FK_tblOrders_tblCustomers]
ALTER TABLE [dbo].[tblOrders]  WITH CHECK ADD  CONSTRAINT [FK_tblOrders_tblOrderTypes] FOREIGN KEY([LateOrder])
REFERENCES [dbo].[tblOrderTypes] ([OrderTypeId])
ALTER TABLE [dbo].[tblOrders] CHECK CONSTRAINT [FK_tblOrders_tblOrderTypes]
