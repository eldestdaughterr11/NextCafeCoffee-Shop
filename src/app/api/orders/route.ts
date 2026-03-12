import { NextRequest, NextResponse } from 'next/server';
import { PrismaClient } from '@prisma/client';

const prisma = new PrismaClient();

export async function POST(req: NextRequest) {
  try {
    const { name, phone, address, paymentMethod, items, total } = await req.json();

    // Hanapin yung user sa database kapag may tumugma sa pangalan
    // O gumawa ng temporary transaction connection kung walang user session (Simpleng approach)
    // Para sa proyektong ito na may basic info lang:
    let user = await prisma.user.findFirst({
      where: { name: name }
    });

    // Kung walang nag-match, gawa muna ng temp user or assign to Admin for now para mag-proceed ang order
    // In production, we should get user id from session.
    if (!user) {
        user = await prisma.user.findFirst({ where: { role: 'admin' } });
    }
    
    // Create actual Order saving sa database
    const order = await prisma.order.create({
      data: {
        userId: user ? user.id : 1, // Fallback lang sa ID 1 kung missing
        total: total,
        status: 'pending',
        items: {
          create: items.map((item: any) => ({
            productId: item.id,
            quantity: item.quantity,
            price: item.price
          }))
        }
      },
      include: {
        items: true
      }
    });

    return NextResponse.json({ message: 'Order created successfully', orderId: order.id }, { status: 201 });
  } catch (error) {
    console.error('Order Error:', error);
    return NextResponse.json({ error: 'Failed to create order' }, { status: 500 });
  }
}
